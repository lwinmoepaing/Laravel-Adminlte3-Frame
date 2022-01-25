<?php

namespace App\Mail;

use App\Appointment;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;


class AcceptInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dateStr = Carbon::parse($this->appointment->meeting_time)->format('F d Y H:i');
        $calendarFormat = Carbon::parse($this->appointment->meeting_time);
        // GMT+6:30
        $calendar = Calendar::create();

        $events = Event::create('Acceptance Meeting of your invitation' . '<A' . str_pad($this->appointment->id, 6, '0', STR_PAD_LEFT) . '>')
                ->startsAt(new DateTime($calendarFormat, new DateTimeZone('Asia/Rangoon')))
                ->endsAt(new DateTime($calendarFormat->addHour(1), new DateTimeZone('Asia/Rangoon')))
                ->address($this->appointment->branch->branch_name)
                ->organizer('lwinmoepaing.dev@gmail.com', 'uab LwinMoePaing')
                ->description($this->appointment->title . ' - ' . $this->appointment->visitors[0]->phone . ' <' . $this->appointment->visitors[0]->email . '> ');

        $ics = $calendar->event($events)->get();

        $extension = '.ics';
        $file = 'invite';

        file_put_contents($file . $extension,
            mb_convert_encoding($ics , "UTF-8", "auto")
        );

        return $this
            ->view('mails.accept-email')
            ->with([
                'title' => $this->appointment->title,
                'start_date' => $dateStr,
                'end_date' => $dateStr,
                'request_from' => $this->appointment->visitors[0]->name . ' (' . $this->appointment->visitors[0]->email . ')',
                'to_email' => $this->appointment->staff_email,
                'department' => $this->appointment->department->department_name,
                'address' => $this->appointment->branch->branch_address,
                'id' => $this->appointment->id,
            ])
            ->attach($file.$extension, ['mime' => 'data:text/calendar;charset=UTF-8;method=REQUEST']);
    }
}
