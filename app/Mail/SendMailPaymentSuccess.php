<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\PcmDmsDocument;

class SendMailPaymentSuccess extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $document;
    protected $config;
    protected $messages;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $document, $config, $messages)
    {
        $this->order = $order;
        $this->document = $document;
        $this->config = $config;
        $this->messages = $messages;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = \Auth::user();
        $isFreeDownload = true;

        if ($this->order->total_amount > 0) {
            $isFreeDownload = false;
        }

        if ($isFreeDownload) {
            $subject = $this->messages->confirmation_email_subject;
            $body    = $this->messages->confirmation_email_body;
        } elseif ($this->order->published) {
            $subject = $this->messages->confirmation_email_subject;
            $body    = $this->messages->confirmation_email_body;
        } else {
            $subject = $this->messages->pay_later_email_subject;
            $body    = $this->messages->pay_later_email_body;
        }

        $html_order_detail = '<div style="margin-top:20px;"><table>
            <tbody>
                <tr>
                    <td>DOCUMENT</td>
                    <td>'. $this->document->title .'</td>
                </tr>' .
                '<tr>
                    <td>DOWNLOAD</td>
                    <td>'. ($this->config->send_download_link ? '<a href="' . route('home.document.download', $this->order->id) . '"><strong>DOWNLOAD</strong></a>' : '<span style="color:#dc3545;">EXPIRED</span>') .'</td>
                </tr>' .
                '<tr>
                    <td>SUB TOTAL</td>
                    <td>'. '$' . $this->order->payment_amount .'</td>
                </tr>' .
                '<tr>
                    <td>TOTAL</td>
                    <td>'. '$' . $this->order->total_amount .'</td>
                </tr>' .
                '<tr>
                    <td>TRANSACTION ID</td>
                    <td>'. $this->order->transaction_id .'</td>
                </tr>' .
            '</tbody>
        </table></div>';

        if (str_contains($body, '[FIRST_NAME] [LAST_NAME]') || str_contains($body, '[FIRST_NAME][LAST_NAME]')) {
            $body = str_replace(['[FIRST_NAME] [LAST_NAME]', '[FIRST_NAME][LAST_NAME]'], $user->name, $body);
        }

        if (str_contains($body, '[ORDER_DETAIL]')) {
            $body = str_replace('[ORDER_DETAIL]', $html_order_detail, $body);
        }

        $mail = $this->view('mail.payment_success')
            ->subject($subject)
            ->from(env('MAIL_FROM_ADDRESS'))
            ->with([
                'subject' => $subject,
                'body' => $body,
            ]);

        if ($this->config->send_document_via_email) {
            $mail = $mail->attach(storage_path(PcmDmsDocument::BASE_URL . $this->document->filename));
        }
        
        return $mail;
    }
}
