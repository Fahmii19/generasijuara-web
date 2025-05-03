<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailInvoice extends Mailable
{
    use Queueable, SerializesModels;

    private $params;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name').' | Invoice')
            ->view('mails.invoice')
            ->with($this->params);
    }
}
