<?php

namespace App\Exports;

use App\Appointment;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDepartmentDetail implements FromCollection, WithHeadings, Responsable
{
    use Exportable;

    protected $startDate, $endDate, $department;

    public function __construct($startDate, $endDate, $department)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->department = $department;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $appointments = Appointment::where('department_id', $this->department->id)
            ->with(['visitor', 'staff', 'room'])
            ->whereBetween('meeting_time', [$this->startDate, $this->endDate])
            ->get();

        $result = [];

        foreach ($appointments as $key => $value) {
            $result[$key]['no'] = $key + 1;
            $result[$key]['title'] = $value->title;
            $result[$key]['staff'] = $value->staff->name . ', ' .
                $value->staff->phone . ', ' .
                $value->staff->email;

            $result[$key]['customer'] = $value->visitor->name . ', ' .
                $value->visitor->phone . ', ' .
                $value->visitor->email;

            $result[$key]['request_time'] = $value->request_time;
            $result[$key]['room'] = $value->room ? $value->room->room_name : '-';
        }

        return new Collection($result);
    }

    public function headings(): array
    {
        return ["No", "Title", "Staff", "Customer", "Date Time", "Room"];
    }
}
