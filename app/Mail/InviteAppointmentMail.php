<?php

namespace App\Mail;

use App\Appointment;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class InviteAppointmentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        //
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $calendar = Calendar::create();
        $events = Event::create('Invitation: Meeting')
                ->startsAt($this->appointment->meeting_time)
                ->endsAt($this->appointment->meeting_time)
                ->address($this->appointment->branch->branch_name)
                ->description($this->appointment->title);

        $ics = $calendar->event($events)->get();

        $extension = '.ics';
        $file = 'invite';

        file_put_contents($file . $extension,
            mb_convert_encoding($ics , "UTF-8", "auto")
        );

        return $this
            ->view('invitation-email')
            ->with([
                'title' => $this->appointment->title,
                'start_date' => $this->appointment->meeting_time,
                'end_date' => $this->appointment->meeting_time,
                'request_from' => $this->appointment->visitors[0]->name,
                'to_email' => $this->appointment->staff_email,
            ])
            ->attach($file.$extension, ['mime' => 'data:text/calendar;charset=UTF-8;method=REQUEST']);
    }
}
