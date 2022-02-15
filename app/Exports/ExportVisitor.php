<?php

namespace App\Exports;

use App\Appointment;
use App\Visitor;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportVisitor implements FromCollection, WithHeadings, Responsable
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
        $visitorQuery = Visitor::getQuery()
            ->selectRaw('email, count(visitors.id) as total_appointment_count')
            ->groupBy('email')
            ->orderByRaw('count(visitors.id) DESC');


        $visitorQuery->whereBetween('created_at', [$this->startDate, $this->endDate]);
        $visitors = $visitorQuery->get();

        foreach ($visitors as $key => $value) {
            $visitor = Visitor::where('email', $value->email)->latest('created_at')->first();
            $value->company_name = $visitor->company_name;
            $value->name = $visitor->name;
            $value->phone = $visitor->phone;
        };

        $result = [];
        foreach ($visitors as $key => $value) {
            $result[$key]['no'] = $key + 1;
            $result[$key]['customer'] = $value->name;
            $result[$key]['phone'] = $value->phone;
            $result[$key]['email'] = $value->email;
            $result[$key]['company_name'] = $value->company_name;
            $result[$key]['total_appointment_count'] = $value->total_appointment_count;
        }

        return new Collection($result);
    }

    public function headings(): array
    {
        return ["No", "Customer", "Phone", "Email", "Company", "Appointments"];
    }
}
