<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendEmailSiabResetPassword;
use Illuminate\Support\Facades\Mail;

class SendSiabResetPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $params;
    protected $receiver;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params = [], array $receiver = [])
    {
        $this->params = $params;
        $this->receiver = $receiver;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ccEmails = !empty(config('mail.cc')) ? explode(",", config('mail.cc')) : null;
        $email = new SendEmailSiabResetPassword($this->params);
        $mail = Mail::to($this->receiver['email'], $this->receiver['name']);
        if (!empty($ccEmails)) $mail->cc($ccEmails);
        $mail->send($email);
    }
}
