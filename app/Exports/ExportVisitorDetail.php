<?php

namespace App\Exports;

use App\Appointment;
use App\Visitor;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportVisitorDetail implements FromCollection, WithHeadings, Responsable
{
    use Exportable;

    protected $startDate, $endDate, $visitor;

    public function __construct($startDate, $endDate, $visitor_email)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->visitor_email = $visitor_email;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $visitors = Visitor::where('email', $this->visitor_email)
            ->with(['appointment.staff', 'appointment.room'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        $result = [];

        foreach ($visitors as $key => $value) {
            $result[$key]['no'] = $key + 1;
            $result[$key]['title'] = $value->appointment->title;


            $result[$key]['customer'] = $value->name . ', ' .
                $value->phone . ', ' .
                $value->email;

            $result[$key]['staff'] = $value->appointment->staff->name . ', ' .
                $value->appointment->staff->phone . ', ' .
                $value->appointment->staff->email;

            $result[$key]['request_time'] = $value->appointment->request_time;
            $result[$key]['room'] = $value->appointment->room ? $value->appointment->room->room_name : '-';
        }

        return new Collection($result);
    }

    public function headings(): array
    {
        return ["No", "Title", "Customer", "Staff",  "Date Time", "Room"];
    }
}
