<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArriveForClientMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($arr)
    {
        //
        $this->appointment = $arr;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this
            ->subject('Your Meeting Start')
            ->from(env('MAIL_FROM_ADDRESS', 'admin@uab.com.mm'), 'uab Meeting Start Mail')
            ->view('mails.arrived-email-for-client', $this->appointment);
    }
}
