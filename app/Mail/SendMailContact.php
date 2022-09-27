<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailContact extends Mailable
{
    protected $data;
    protected $site_name;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$site_name)
    {
        $this->data = $data;
        $this->site_name = $site_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.contact')
            ->subject("[Contact Pcmdonation] " . $this->data['subject'])
            ->from($this->data['email'])
            ->with([
                'data' => $this->data,
                'site_name' => $this->site_name,
            ]);
    }
}
