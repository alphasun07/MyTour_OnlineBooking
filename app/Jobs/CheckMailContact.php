<?php

namespace App\Jobs;

use App\Mail\SendMailContact;
use App\Mail\SendMailRegister;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CheckMailContact implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $admin_contact;
    protected $site_name;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $admin_contact, $site_name)
    {
        $this->data = $data;
        $this->admin_contact = $admin_contact;
        $this->site_name = $site_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->admin_contact)->send(new SendMailContact($this->data,$this->site_name));
    }
}
