<?php

namespace App\Exports;

use App\Appointment;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDepartment implements FromCollection, WithHeadings, Responsable
{
    use Exportable;

    protected $startDate, $endDate;


    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $appointmentQuery = Appointment::getQuery()
            ->selectRaw('department_name, count(appointments.id) as total_appointment_count')
            ->join('departments', 'departments.id', '=', 'appointments.department_id')
            ->groupBy('department_id')
            ->orderByRaw('count(appointments.id) DESC');
        $appointmentQuery->whereBetween('meeting_time', [$this->startDate, $this->endDate]);
        $appointments = $appointmentQuery->get();

        $result = [];
        foreach ($appointments as $key => $value) {
            $result[$key]['no'] = $key + 1;
            $result[$key]['department_name'] = $value->department_name;
            $result[$key]['total_appointment_count'] = $value->total_appointment_count;
        }

        return new Collection($result);
    }

    public function headings(): array
    {
        return ["No", "Departments", "Appointments"];
    }
}
