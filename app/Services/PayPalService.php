<?php

namespace App\Services;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\Payer;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PPConnectionException;
use Request;

class PayPalService
{
	// Contains the context of the API
	private $apiContext;
    // Contains a list of items (items)
    private $itemList;
    // Payment unit
    private $paymentCurrency;
    // Total amount of the order
    private $totalAmount;
    // Path to a successful payment processing
    private $returnUrl;
    // Path to handle when the user clicks cancel (no payment)
    private $cancelUrl;

    public function __construct()
    {
    	// Read the settings in the config file
        $paypalConfigs = config('paypal');

        // Context Initialization
        $this->apiContext = new ApiContext(
        	new OAuthTokenCredential(
            	$paypalConfigs['client_id'],
                $paypalConfigs['secret']
            )
        );

        // Set default currency for payment
        $this->paymentCurrency = "USD";

        // Initialize total amount
        $this->totalAmount = 0;
    }

    /**
     * Set payment currency
     *
     * @param string $currency String name of currency
     * @return self
     */
	public function setCurrency($currency)
    {
    	$this->paymentCurrency = $currency;

        return $this;
    }

    /**
     * Get current payment currency
     *
     * @return string Current payment currency
     */
    public function getCurrency()
    {
        return $this->paymentCurrency;
    }

    /**
     * Add item to list
     *
     * @param array $itemData Array item data
     * @return self
     */
    public function setItem($itemData)
    {
        // Check if added item is one or one
        // array of items. If it's just 1 item, then we will
        // make it an array of items and then foreach. This helps
        // we can add one or more items at the same time
        if (count($itemData) === count($itemData, COUNT_RECURSIVE)) {
            $itemData = [$itemData];
        }

        // Browse the list of items
        foreach ($itemData as $data) {
        	// Initialize item
            $item = new Item();

            // Set the name of the item
            $item->setName($data['name'])
                 ->setCurrency($this->paymentCurrency) // Money unit of the item
                 ->setSku($data['sku']) // Item ID
                 ->setQuantity($data['quantity']) // Amount
                 ->setPrice($data['price']); // Price
			// Add item to the list
            $this->itemList[] = $item;
            // Calculate total order
            $this->totalAmount += $data['price'] * $data['quantity'];
        }

        return $this;
    }

    /**
     * Get list item
     *
     * @return array List item
     */
    public function getItemList()
    {
        return $this->itemList;
    }

    /**
     * Get total amount
     *
     * @return mixed Total amount
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set return URL
     *
     * @param string $url Return URL for payment process complete
     * @return self
     */
    public function setReturnUrl($url)
    {
        $this->returnUrl = $url;

        return $this;
    }

    /**
     * Get return URL
     *
     * @return string Return URL
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * Set cancel URL
     *
     * @param $url Cancel URL for payment
     * @return self
     */
    public function setCancelUrl($url)
    {
        $this->cancelUrl = $url;

        return $this;
    }

    /**
     * Get cancel URL of payment
     *
     * @return string Cancel URL
     */
    public function getCancelUrl()
    {
        return $this->cancelUrl;
    }

    /**
     * Create payment
     *
     * @param string $transactionDescription Description for transaction
     * @return mixed Paypal checkout URL or false
     */
    public function createPayment($transactionDescription)
    {
        $checkoutUrl = false;

        // Select a payment type.
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        // List of items
        $itemList = new ItemList();
        $itemList->setItems($this->itemList);

        // Total amount and type of money to use for payment.
        // You should match the item's currency and the order's currency
        // avoid the case that the item's currency is JPY but that of the order
        // it's USD again.
        $amount = new Amount();
        $amount->setCurrency($this->paymentCurrency)
               ->setTotal($this->totalAmount);

        // Transaction
        $transaction = new Transaction();
        $transaction->setAmount($amount)
                    ->setItemList($itemList)
                    ->setDescription($transactionDescription);

        // Path to a successful payment processing.
        $redirectUrls = new RedirectUrls();

        // Check if the link exists when the user cancels the payment
        // or not. Otherwise, we will use $redirectUrl . by default
        if (is_null($this->cancelUrl)) {
            $this->cancelUrl = $this->returnUrl;
        }

        $redirectUrls->setReturnUrl($this->returnUrl)
                     ->setCancelUrl($this->cancelUrl);

        // Initialize a payment
        $payment = new Payment();
        $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

		// Perform payment creation
        try {
            $payment->create($this->apiContext);
        } catch (PPConnectionException $paypalException) {
            throw new \Exception($paypalException->getMessage());
        }

        // If the payment creation is successful. We will receive
        // get a list of paths associated with the
        // pay on PayPal
        foreach ($payment->getLinks() as $link) {
        	// Browse each link and get the link that has the rel
            // is approval_url then assign it to $checkoutUrl
            // to redirect the user there.
            if ($link->getRel() == 'approval_url') {
                $checkoutUrl = $link->getHref();
				// Save payment ID in session to check
                // pay in another function
                session(['paypal_payment_id' => $payment->getId()]);
                \Log::info('paypal_payment_id: ' . session('paypal_payment_id'));
                break;
            }
        }

		// Returns the payment url to do the redirect
        return [
            'paymentId' => $payment->getId(),
            'checkoutUrl' => $checkoutUrl
        ];
    }

    /**
     * Get payment status
     *
     * @return mixed Object payment details or false
     */
    public function getPaymentStatus()
    {
    	// Initialize a request to get some of the above queries
        // URL returned from PayPal
        $request = Request::all();
        //return $request;

        // Get Payment ID from session
        $paymentId = session('paypal_payment_id');

        // Delete the payment ID saved in the session
        session()->forget('paypal_payment_id');

        // Check if the return URL from PayPal contains
        // necessary queries for a successful payment
        // or not.
        if (empty($request['PayerID']) || empty($request['token'])) {
            return false;
        }

        // Initialize payment from existing Payment ID
        $payment = Payment::get($paymentId, $this->apiContext);

        // Execute payment and get payment details
        $paymentExecution = new PaymentExecution();
        $paymentExecution->setPayerId($request['PayerID']);

        $paymentStatus = $payment->execute($paymentExecution, $this->apiContext);

        return $paymentStatus;
    }

    /**
     * Get payment list
     *
     * @param int $limit Limit number payment
     * @param int $offset Start index payment
     * @return mixed Object payment list
     */
    public function getPaymentList($limit = 10, $offset = 0)
    {
        $params = [
            'count' => $limit,
            'start_index' => $offset
        ];

        try {
            $payments = Payment::all($params, $this->apiContext);
        } catch (PPConnectionException $paypalException) {
            throw new \Exception($paypalException->getMessage());
        }

        return $payments;
    }

    /**
     * Get payment details
     *
     * @param string $paymentId PayPal payment Id
     * @return mixed Object payment details
     */
    public function getPaymentDetails($paymentId)
    {
        try {
            $paymentDetails = Payment::get($paymentId, $this->apiContext);
        } catch (PPConnectionException $paypalException) {
            throw new \Exception($paypalException->getMessage());
        }

        return $paymentDetails;
    }
}