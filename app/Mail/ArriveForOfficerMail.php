<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArriveForOfficerMail extends Mailable
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
            ->subject('Visitor Arrival Mail')
            ->from(env('MAIL_FROM_ADDRESS', 'admin@uab.com.mm'), 'uab Visitor Arrived')
            ->view('mails.arrived-email-for-officer', $this->appointment);
    }
}
