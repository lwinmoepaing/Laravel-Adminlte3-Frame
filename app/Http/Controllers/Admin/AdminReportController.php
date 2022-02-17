<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Department;
use App\Exports\ExportDepartment;
use App\Exports\ExportDepartmentDetail;
use App\Exports\ExportVisitor;
use App\Http\Controllers\Controller;
use App\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;

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
                $startOfDay = Carbon::parse($date[0])->startOfDay()->format('Y-m-d H:i:s');
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
                $startOfDay = Carbon::parse($date[0])->startOfDay()->format('Y-m-d H:i:s');
                $endOfDay = Carbon::parse($date[1])->endOfDay()->format('Y-m-d H:i:s');
            }
        }

        $department = new ExportDepartment($startOfDay, $endOfDay);
        $excelName = 'departments_from_' . Carbon::parse($startOfDay)->format('Y_m_d') . '_to_' . Carbon::parse($endOfDay)->format('Y_m_d') .'.xlsx';
        return Excel::download($department, $excelName);
    }

    public function exportDepartmentPDF(Request $request) {
        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');


        $appointmentQuery = Appointment::getQuery()
            ->selectRaw('department_id, department_name, count(appointments.id) as total_appointment_count')
            ->join('departments', 'departments.id', '=', 'appointments.department_id')
            ->groupBy('department_id')
            ->orderByRaw('count(appointments.id) DESC');

        $dateQuery = $request->date;
        if ($dateQuery) {
            $date = explode(' - ', $dateQuery);
            if (count($date) > 1) {
                $startOfDay = Carbon::parse($date[0])->startOfDay()->format('Y-m-d H:i:s');
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

        $pdf = PDF::loadView('admin.reports.pdf-department-view', $responseData);
        $pdfName = 'departments_from_' . Carbon::parse($startOfDay)->format('Y_m_d') . '_to_' . Carbon::parse($endOfDay)->format('Y_m_d') .'.pdf';
        return $pdf->download($pdfName);
    }

    public function showVisitorList(Request $request) {

        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');

        $visitorQuery = Visitor::getQuery()
            ->selectRaw('email, count(visitors.id) as total_appointment_count')
            ->groupBy('email')
            ->orderByRaw('count(visitors.id) DESC');

        $dateQuery = $request->query('date');
        if ($dateQuery) {
            $date = explode(' - ', $dateQuery);
            if (count($date) > 1) {
                $startOfDay = Carbon::parse($date[0])->startOfDay()->format('Y-m-d H:i:s');
                $endOfDay = Carbon::parse($date[1])->endOfDay()->format('Y-m-d H:i:s');
            }
        }

        $visitorQuery->whereBetween('created_at', [$startOfDay, $endOfDay]);
        $visitors = $visitorQuery->get();

        foreach ($visitors as $key => $value) {
            $visitor = Visitor::where('email', $value->email)->latest('created_at')->first();
            $value->company_name = $visitor->company_name;
            $value->name = $visitor->name;
            $value->phone = $visitor->phone;
        };

        $responseData = [
            'visitors' => $visitors,
            'startOfDay' => Carbon::parse($startOfDay)->format('Y-m-d'),
            'endOfDay' => Carbon::parse($endOfDay)->format('Y-m-d'),
            'navTitle' => 'Reports'
        ];

        // return response()->json($responseData);

        return view('admin.reports.report-visitor-view', $responseData);
    }

    public function exportVisitorPDF(Request $request) {

        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');

        $visitorQuery = Visitor::getQuery()
            ->selectRaw('email, count(visitors.id) as total_appointment_count')
            ->groupBy('email')
            ->orderByRaw('count(visitors.id) DESC');

        $dateQuery = $request->query('date');
        if ($dateQuery) {
            $date = explode(' - ', $dateQuery);
            if (count($date) > 1) {
                $startOfDay = Carbon::parse($date[0])->startOfDay()->format('Y-m-d H:i:s');
                $endOfDay = Carbon::parse($date[1])->endOfDay()->format('Y-m-d H:i:s');
            }
        }

        $visitorQuery->whereBetween('created_at', [$startOfDay, $endOfDay]);
        $visitors = $visitorQuery->get();

        foreach ($visitors as $key => $value) {
            $visitor = Visitor::where('email', $value->email)->latest('created_at')->first();
            $value->company_name = $visitor->company_name;
            $value->name = $visitor->name;
            $value->phone = $visitor->phone;
        };

        $responseData = [
            'visitors' => $visitors,
            'startOfDay' => Carbon::parse($startOfDay)->format('Y-m-d'),
            'endOfDay' => Carbon::parse($endOfDay)->format('Y-m-d'),
            'navTitle' => 'Reports'
        ];

        // return response()->json($responseData);

        $pdf = PDF::loadView('admin.reports.pdf-visitor-view', $responseData);
        $pdfName = 'visitors_from_' . Carbon::parse($startOfDay)->format('Y_m_d') . '_to_' . Carbon::parse($endOfDay)->format('Y_m_d') .'.pdf';
        return $pdf->download($pdfName);
    }

    public function exportVisitor(Request $request) {
        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');

        $dateQuery = $request->date;
        if ($dateQuery) {
            $date = explode(' - ', $dateQuery);
            if (count($date) > 1) {
                $startOfDay = Carbon::parse($date[0])->startOfDay()->format('Y-m-d H:i:s');
                $endOfDay = Carbon::parse($date[1])->endOfDay()->format('Y-m-d H:i:s');
            }
        }

        $visitor = new ExportVisitor($startOfDay, $endOfDay);
        $excelName = 'visitors_from_' . Carbon::parse($startOfDay)->format('Y_m_d') . '_to_' . Carbon::parse($endOfDay)->format('Y_m_d') .'.xlsx';
        return Excel::download($visitor, $excelName);
    }

    public function showDepartmentDetail(Request $request) {

        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');

        $dateQuery = $request->query('date');
        if ($dateQuery) {
            $date = explode(' - ', $dateQuery);
            if (count($date) > 1) {
                $startOfDay = Carbon::parse($date[0])->startOfDay()->format('Y-m-d H:i:s');
                $endOfDay = Carbon::parse($date[1])->endOfDay()->format('Y-m-d H:i:s');
            }
        }

        $department = Department::find($request->department_id);

        $appointments = Appointment::where('department_id', $request->department_id)
            ->with(['visitor', 'staff', 'room'])
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->get();

        $responseData = [
            'startOfDay' => Carbon::parse($startOfDay)->format('Y-m-d'),
            'endOfDay' => Carbon::parse($endOfDay)->format('Y-m-d'),
            'navTitle' => 'Reports',
            'appointments' => $appointments,
            'department' => $department,
        ];

        // return response()->json($responseData);

        return view('admin.reports.report-department-detail', $responseData);
    }

    public function exportDepartmentDetail(Request $request) {
        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');

        $dateQuery = $request->date;
        if ($dateQuery) {
            $date = explode(' - ', $dateQuery);
            if (count($date) > 1) {
                $startOfDay = Carbon::parse($date[0])->startOfDay()->format('Y-m-d H:i:s');
                $endOfDay = Carbon::parse($date[1])->endOfDay()->format('Y-m-d H:i:s');
            }
        }

        $department = Department::find($request->department_id);

        $visitor = new ExportDepartmentDetail($startOfDay, $endOfDay, $department);

        $excelName = $department->department_name . '_from_' . Carbon::parse($startOfDay)->format('Y_m_d') . '_to_' . Carbon::parse($endOfDay)->format('Y_m_d') .'.xlsx';
        return Excel::download($visitor, $excelName);
    }

    public function exportDepartmentDetailPDF(Request $request) {
        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');

        $dateQuery = $request->query('date');
        if ($dateQuery) {
            $date = explode(' - ', $dateQuery);
            if (count($date) > 1) {
                $startOfDay = Carbon::parse($date[0])->startOfDay()->format('Y-m-d H:i:s');
                $endOfDay = Carbon::parse($date[1])->endOfDay()->format('Y-m-d H:i:s');
            }
        }

        $department = Department::find($request->department_id);

        $appointments = Appointment::where('department_id', $request->department_id)
            ->with(['visitor', 'staff', 'room'])
            ->whereBetween('meeting_time', [$startOfDay, $endOfDay])
            ->get();

        $responseData = [
            'startOfDay' => Carbon::parse($startOfDay)->format('Y-m-d'),
            'endOfDay' => Carbon::parse($endOfDay)->format('Y-m-d'),
            'navTitle' => 'Reports',
            'appointments' => $appointments,
            'department' => $department,
        ];

        // return response()->json($responseData);

        $pdf = PDF::loadView('admin.reports.pdf-department-detail', $responseData);
        $pdfName =  $department->department_name . '_from_' . Carbon::parse($startOfDay)->format('Y_m_d') . '_to_' . Carbon::parse($endOfDay)->format('Y_m_d') .'.pdf';
        return $pdf->download($pdfName);
    }

    public function showVisitorDetail(Request $request) {

        $startDayQuery = Carbon::now()->subDays(30)->startOfDay();
        $endDayQuery = Carbon::now()->endOfDay();
        $startOfDay = $startDayQuery->format('Y-m-d H:i:s');
        $endOfDay = $endDayQuery->format('Y-m-d H:i:s');

        $dateQuery = $request->query('date');
        if ($dateQuery) {
            $date = explode(' - ', $dateQuery);
            if (count($date) > 1) {
                $startOfDay = Carbon::parse($date[0])->startOfDay()->format('Y-m-d H:i:s');
                $endOfDay = Carbon::parse($date[1])->endOfDay()->format('Y-m-d H:i:s');
            }
        }

        $appointments = Visitor::where('email', $request->visitor_email)
            ->with(['appointment'])
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->get();

        $responseData = [
            'startOfDay' => Carbon::parse($startOfDay)->format('Y-m-d'),
            'endOfDay' => Carbon::parse($endOfDay)->format('Y-m-d'),
            'navTitle' => 'Reports',
            'appointments' => $appointments,
        ];

        return response()->json($responseData);

        // return view('admin.reports.report-department-detail', $responseData);
    }
}
