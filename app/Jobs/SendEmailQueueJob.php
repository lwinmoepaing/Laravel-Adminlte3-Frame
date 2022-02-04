<?php

namespace App\Jobs;

use App\Appointment;
use App\Mail\InviteAppointmentMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $appointment, $mailType;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment, $mailType)
    {
        $this->appointment = $appointment;
        $this->mailType = $mailType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->appointment->email)->send(new InviteAppointmentMail($this->appointment));
    }
}
