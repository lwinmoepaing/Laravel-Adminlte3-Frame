<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Exports\ExportDepartment;
use App\Http\Controllers\Controller;
use App\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AdminReportController extends Controller
{
    public function showReportDashboard() {
        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');

        $appointments = Appointment::getQuery()
            ->selectRaw('department_id, department_name, count(appointments.id) as total_appointment_count')
            ->join('departments', 'departments.id', '=', 'appointments.department_id')
            ->groupBy('department_id')
            ->orderByRaw('count(appointments.id) DESC')
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->take(5)
            ->get();

        $total_appointments = 0;
        foreach ($appointments as $key => $value) {
           $total_appointments += $value->total_appointment_count;
        }

        $visitors = Visitor::getQuery()
            ->selectRaw('email, count(visitors.id) as total_appointment_count')
            ->groupBy('email')
            ->orderByRaw('count(visitors.id) DESC')
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->take(10)
            ->get();

        foreach ($visitors as $key => $value) {
            $visitor = Visitor::where('email', $value->email)->latest('created_at')->first();
            $value->company_name = $visitor->company_name;
            $value->name = $visitor->name;
        };

        $responseData = [
            'appointments' => $appointments,
            'visitors' => $visitors,
            'total_appiontments' => $total_appointments,
            'startOfDay' => $startDayQuery->format('d M Y'),
            'endOfDay' => $endDayQuery->format('d M Y'),
            'navTitle' => 'Reports'
        ];

        // return response()->json($responseData);

        return view('admin.reports.report-view', $responseData);
    }

    public function showDepartmentList(Request $request) {

        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');


        $appointmentQuery = Appointment::getQuery()
            ->selectRaw('department_id, department_name, count(appointments.id) as total_appointment_count')
            ->join('departments', 'departments.id', '=', 'appointments.department_id')
            ->groupBy('department_id')
            ->orderByRaw('count(appointments.id) DESC');

        $dateQuery = $request->query('date');
        if ($dateQuery) {
            $date = explode(' - ', $dateQuery);
            if (count($date) > 1) {
                $startOfDay = Carbon::parse($date[0])->format('Y-m-d H:i:s');
                $endOfDay = Carbon::parse($date[1])->endOfDay()->format('Y-m-d H:i:s');
            }
        }

        $appointmentQuery->whereBetween('meeting_time', [$startOfDay, $endOfDay]);
        $appointments = $appointmentQuery->get();

        $total_appointments = 0;
        foreach ($appointments as $key => $value) {
           $total_appointments += $value->total_appointment_count;
        }

        $responseData = [
            'appointments' => $appointments,
            'total_appiontments' => $total_appointments,
            'startOfDay' => Carbon::parse($startOfDay)->format('Y-m-d'),
            'endOfDay' => Carbon::parse($endOfDay)->format('Y-m-d'),
            'navTitle' => 'Reports'
        ];

        // return response()->json($responseData);

        return view('admin.reports.report-department-view', $responseData);
    }

    public function exportDepartment(Request $request) {
        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');

        $dateQuery = $request->date;
        if ($dateQuery) {
            $date = explode(' - ', $dateQuery);
            if (count($date) > 1) {
                $startOfDay = Carbon::parse($date[0])->format('Y-m-d H:i:s');
                $endOfDay = Carbon::parse($date[1])->endOfDay()->format('Y-m-d H:i:s');
            }
        }

        $department = new ExportDepartment($startOfDay, $endOfDay);
        $excelName = 'departments_from_' . Carbon::parse($startOfDay)->format('Y_m_d') . '_to_' . Carbon::parse($endOfDay)->format('Y_m_d') .'.xlsx';
        return Excel::download($department, $excelName);
    }
}
