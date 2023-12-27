<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class senderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $testMailData;


    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }
    public function build()
    {
        return $this->subject('RRGMONEY EMAIL NOTIFICATION')
                     ->view('email.senderNotification');

    }

}
