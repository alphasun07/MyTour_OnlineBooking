<?php

namespace App\Jobs;

use App\Mail\SendMailByOrder;
use App\Mail\SendMailRegister;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CheckMailRegister implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    protected $sender;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $sender)
    {
        $this->data = $data;
        $this->sender = $sender;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->sender)->send(new SendMailRegister($this->data, $this->sender));
    }
}
