<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailRegister extends Mailable
{
    protected $data;
    protected $sender;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $sender)
    {
        $this->data = $data;
        $this->sender = $sender;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.register')
            ->subject("Your account has been registered")
            ->from($this->sender)
            ->with([
                'data' => $this->data,
            ]);
    }
}
