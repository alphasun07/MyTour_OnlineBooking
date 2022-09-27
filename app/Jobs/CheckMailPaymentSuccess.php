<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailPaymentSuccess;

class CheckMailPaymentSuccess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $document;
    protected $config;
    protected $messages;

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->order['email'])->send(new SendMailPaymentSuccess($this->order, $this->document, $this->config, $this->messages));
    }
}
