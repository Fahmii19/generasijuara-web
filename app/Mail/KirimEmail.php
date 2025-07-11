<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KirimEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $alumniData;

    public function __construct($alumniData)
    {
        $this->alumniData = $alumniData;
    }

    public function build()
    {
        return $this->subject('Pendataan Alumni Baru')
            ->view('emails.alumni_notification');
    }
}
