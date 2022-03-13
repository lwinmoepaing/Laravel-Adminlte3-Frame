<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Branch;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAppointmentUpdateRequest;
use App\Http\Requests\ClientAppointmentRequest;
use App\Mail\ArriveForClientMail;
use App\Mail\ArriveForOfficerMail;
use App\Room;
use App\Service\AppointmentService;
use App\Staff;
use App\Visitor;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminAppointmentController extends Controller
{
    private $appointmentService;

    public function __construct()
    {
        $this->appointmentService = new AppointmentService();
    }

    public function showDashboard(Request $request) {
        $startOfDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endOfDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        $pendingStatus = Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'];
        $arrivedStatus = Appointment::$APPOINTMENT_STATUS_TYPE['OCCUPIED'];

        $searchDate = Carbon::now()->startOfDay()->format('Y/m/d');

        if ($request->query('search_date')) {
            $requestDate = $request->query('search_date');
            $parseDate = Carbon::createFromFormat('m/d/Y', $requestDate, 'Asia/Rangoon');
            $searchDate = $parseDate->format('Y-m-d');
            $startOfDay =  $parseDate->startOfDay()->format('Y-m-d H:i:s');
            $endOfDay =  $parseDate->endOfDay()->format('Y-m-d H:i:s');
        }

        // If Expired Meeting We'll Set Expired Appointment
        $this->appointmentService->expiredDateCheckAndCalculate();

        $todayRequestAppointments = $this->appointmentService->getAppointmentList($pendingStatus, $startOfDay, $endOfDay, $request->query(), ['visitors', 'staffs']);
        $pendingAppointments = $this->appointmentService->getAppointmentList($pendingStatus, $startOfDay, $endOfDay);
        $occupiedAppointments = $this->appointmentService->getAppointmentList($arrivedStatus, $startOfDay, $endOfDay);
        $upcomingAppointments = $this->appointmentService->getUpcomingAppointmentFromPendingList($todayRequestAppointments);

        $responseData = [
            'todayRequestAppointments' => $todayRequestAppointments,
            'todayRequestAppointmentCount' => $pendingAppointments->count() - $upcomingAppointments->count(),
            'occupiedAppointments' => $occupiedAppointments,
            'occupiedAppointmentCount' => $occupiedAppointments->count(),
            'upcomingAppointments' => $upcomingAppointments,
            'upcomingAppointmentCount' => $upcomingAppointments->count(),
            'searchDate' => $searchDate,
            'queryName' => $request->query('search_name'),
            'request' => $request->query()
        ];

        // return response()->json($responseData);

        return view('admin.dashboard', $responseData);
    }

    public function showTodayAppointmentList(Request $request) {
        $startOfDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endOfDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        $pendingStatus = Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'];
        $arrivedStatus = Appointment::$APPOINTMENT_STATUS_TYPE['OCCUPIED'];
        $finishedStatus = Appointment::$APPOINTMENT_STATUS_TYPE['FINISHED'];


        $searchDate = Carbon::now()->startOfDay()->format('Y/m/d');

        if ($request->query('search_date')) {
            $requestDate = $request->query('search_date');
            $parseDate = Carbon::createFromFormat('m/d/Y', $requestDate, 'Asia/Rangoon');
            $searchDate = $parseDate->format('Y-m-d');

            $startOfDay =  $parseDate->startOfDay()->format('Y-m-d H:i:s');
            $endOfDay =  $parseDate->endOfDay()->format('Y-m-d H:i:s');
        }

        $todayRequestAppointments = $this->appointmentService->getAppointmentList($pendingStatus, $startOfDay, $endOfDay, $request->query(), ['visitors', 'staffs']);
        $pendingAppointments = $this->appointmentService->getAppointmentList($pendingStatus, $startOfDay, $endOfDay);
        $occupiedAppointments = $this->appointmentService->getAppointmentList($arrivedStatus, $startOfDay, $endOfDay);
        $upcomingAppointments = $this->appointmentService->getUpcomingAppointmentFromPendingList($todayRequestAppointments);
        $finishedAppointments = $this->appointmentService->getAppointmentList($finishedStatus, $startOfDay, $endOfDay);

        $responseData = [
            'todayRequestAppointmentCount' => $pendingAppointments->count() - $upcomingAppointments->count(),
            'upcommingAppointmentCount' => $upcomingAppointments->count(),
            'occupiedAppointmentCount' => $occupiedAppointments->count(),
            'finishedAppointmentCount' => $finishedAppointments->count(),
            'todayUpcomingAppointments' => $upcomingAppointments,
            'todayRequestAppointments' => $todayRequestAppointments,
            'todayOccupiedAppointments' => $occupiedAppointments,
            'finishedAppointments' => $finishedAppointments,
            'showTab' => $request->query('showTab'),
            'searchDate' => $searchDate,
            'navTitle' => 'Appointments'
        ];

        // return response()->json($responseData);

        return view('admin.appointment.appointment-view', $responseData);
    }

    public function showAppointmentDetail(Appointment $appointment_id) {
        $appointment = $appointment_id->load(['branch', 'room', 'visitors', 'staffs.department']);

        $roomQuery = Room::where('branch_id', $appointment->branch_id);

        $appointmentStatus = Appointment::$APPOINTMENT_STATUS_TYPE;
        $appointmentStatusList = [];

        // When Appointment Pending , Show All Free Rooms
        if ($appointment->status == $appointmentStatus["PENDING"]) {
            $roomQuery = $roomQuery->where('status', Room::$APPOINTMENT_STATUS_TYPE['VACANT']);
            $rooms = $roomQuery->get();
            $appointmentStatusList = [
                'Pending' => $appointmentStatus["PENDING"],
                'Arrived' => $appointmentStatus["OCCUPIED"],
                'Rejected' => $appointmentStatus['REJECTED'],
            ];
        }

        // If Appointment is OCCUPIED , REJECT , FINISHED , EXPIRED, Rooms are not valid
        if ($appointment->status != $appointmentStatus["PENDING"]) {
            $rooms = [];
        }

        // If Appointment status is Arrived
        if ($appointment->status == $appointmentStatus["OCCUPIED"]) {
            $appointmentStatusList = [
                'Arrived' => $appointmentStatus["OCCUPIED"],
                'Finished' => $appointmentStatus["FINISHED"],
            ];
        }

        if ($appointment->status == $appointmentStatus["REJECTED"]) {
            $appointmentStatusList = [
                'Rejected' => $appointmentStatus["REJECTED"],
            ];
        }

        if ($appointment->status == $appointmentStatus["FINISHED"]) {
            $appointmentStatusList = [
                'Finished' => $appointmentStatus["FINISHED"],
            ];
        }

        $responseData = [
            'navTitle' => 'Appointment - ID ' . $appointment_id->id,
            'appointment_id' => $appointment->id,
            'appointmentStatusList' => $appointmentStatusList,
            'appointment' => $appointment,
            'rooms' => $rooms,
        ];

        // return response()->json($responseData);

        return view('admin.appointment.appointment-detail', $responseData);
    }

    public function showCreateForm(Request $request) {
        $branches = Branch::with('township')->get();
        $departments = Department::all();

        $fixedQuery = $request->query('fixed_staff');

        if ($fixedQuery) {
            $existingStaff = Staff::find($fixedQuery);
        }

        $responseData = [
            'branches' => $branches,
            'departments' => $departments,
            'existingStaff' => $existingStaff ?? null,
        ];

        // return response()->json($responseData);

        return view('admin.appointment.appointment-create', $responseData);
    }

    public function submitUpdateAppointment(AdminAppointmentUpdateRequest $request, $appointment_id) {
        $validated = $request->validated();
        $appointmentStatus = Appointment::$APPOINTMENT_STATUS_TYPE;
        $appointment = Appointment::with(['visitors', 'visitor'])->find($appointment_id);

        // Cancel Process
        if ( $validated['status'] == $appointmentStatus["REJECTED"] ) {
           $appointment->fill(['status'=> $validated['status']]);
           $appointment->save();
           return back()
                    ->with('success', 'Successfully Rejected!!');
        }

        // Pending Change -> Pending Process
        if ( $validated['status'] == $appointmentStatus["PENDING"] ) {
            return back()
                    ->with('error', 'You need to change Pending Status first.')
                    ->with('pendingError', 'You can choose Arrived or Reject');
        }

        // Pending -> Occupied Changing Process
        if ( $validated['status'] == $appointmentStatus['OCCUPIED'] ) {

            // If Old Status is Occupied
            if ($appointment->status == $validated['status']) {
                return back()
                        ->with('roomError', 'Status is already arriving.')
                        ->with('error', 'You need to change Arrived Status.');
            }

            if (!isset($validated['room_id'])) {
                return back()
                        ->with('roomError', 'You need to wait available room.')
                        ->with('error', 'You need to wait available room.');
            }

            DB::beginTransaction();
            try {
                $appointment->fill([
                    'status' => $validated['status'],
                    'room_id' => $validated['room_id'],
                ]);
                $appointment->save();
                $room = Room::find($validated['room_id']);
                $room->status = Room::$APPOINTMENT_STATUS_TYPE['OCCUPIED'];
                $room->save();
                DB::commit();

                // SMS send to Officer
                // Now We change SMS to Mail Service
                Mail::to($appointment->staff_email)->queue(new ArriveForOfficerMail([
                    'title' => $appointment->title,
                    'id' => $appointment->id,
                    'room' => $room,
                    'visitor' => $appointment->visitor
                ]));

                foreach ($appointment->visitors as $key => $visitor) {
                    Mail::to($visitor->email)->queue(new ArriveForClientMail([
                        'title' => $appointment->title,
                        'id' => $appointment->id,
                        'room' => $room,
                    ]));
                }

                return back()
                        ->with('success', 'Successfully Update Arrived Status');
            } catch(QueryException $e) {
                DB::rollBack();
                return back()
                        ->with('error', $e->getMessage());
            }

        }

        // Occupied -> Finished Changing Process
        if ( $validated['status'] == $appointmentStatus['FINISHED'] ) {
            DB::beginTransaction();
            try {
                $appointment->fill([
                    'status' => $validated['status'],
                    'meeting_leave_time' => Carbon::now()
                ]);
                $appointment->save();
                $room = Room::find($appointment->room_id);
                $room->status = Room::$APPOINTMENT_STATUS_TYPE['VACANT'];
                $room->save();
                DB::commit();
                return back()
                        ->with('success', 'Successfully Finished This Appointment');
            } catch(QueryException $e) {
                DB::rollBack();
                return back()
                        ->with('error', $e->getMessage());
            }

        }

        return back()->with('success', 'Hello ' . $appointment_id);
    }

    public function submitCreate(ClientAppointmentRequest $request) {
        $validated = $request->validated();
        $staff = Staff::with(['branch'])->where('email', $validated['staff_email'])->first();
        $validated["create_type"] = Appointment::$APPOINTMENT_CREATE_TYPE['FROM_RECIPIENT'];
        $validated["staff_id"] = $staff->id;
        $validated["staff_name"] = $staff->name;
        $validated["department"] = $staff->department_id;
        $validated["create_by_user_id"] = auth()->id();

        $appModel = new Appointment();
        $appointment = $appModel->creatAppointment(
            $validated,
            Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'],
            Appointment::$APPOINTMENT_CREATE_TYPE['FROM_RECIPIENT']
        );

        if (!$appointment) {
            return back()->with('error', 'Something Went Wrong');
        }

        return redirect()->route('admin.appointment.appointment-detail', ['appointment_id' => $appointment->id])
            ->with('success', 'Successfully Created');
    }

    public function showAppointmentEditDetail(Appointment $appointment_id) {
        $appointment = $appointment_id->load(['visitors', 'department', 'branch']);

        $branches = Branch::with('township')->get();
        $departments = Department::all();


        if ($appointment->status !== 1) {
            return redirect()->route('admin.dashboard');
        }

        foreach ($appointment->visitors as $key => $value) {
            $appointment->visitors[$key]['isTouched'] = true;
        }

        $responseData = [
            'navTitle' => 'Appointment - ID ' . $appointment_id->id,
            'appointment_id' => $appointment_id->id,
            'appointment' => $appointment,
            'branches' => $branches,
            'departments' => $departments,
        ];

        // return response()->json($responseData);

        return view('admin.appointment.appointment-edit', $responseData);
    }

    public function submitEdit(ClientAppointmentRequest $request, Appointment $appointment_id) {
        $validated = $request->validated();
        $allNewVisitorsList = [];
        $exisitingVisitorList = [];
        $removeVisitorList = [];

        foreach($validated['visitors'] as $visitor) {
            if (!isset($visitor["id"])) {
                $allNewVisitorsList[] = $visitor;
            } else {
                $exisitingVisitorList[] = $visitor;
            }
        }


        $appointment = $appointment_id->load(['visitors']);
        $staff = Staff::with(['branch'])->where('email', $validated['staff_email'])->first();

        DB::beginTransaction();
        try {
            $appointment->title = $validated['title'];
            $appointment->meeting_time = new DateTime($validated['date'] . ' ' . $validated['time']);
            $appointment->staff_email = $staff->email;
            $appointment->staff_id = $staff->id;
            $appointment->staff_name = $staff->name;
            $appointment->save();

            foreach ($allNewVisitorsList as $item) {
                $visitor = new Visitor();
                $visitor->name = $item['name'] ;
                $visitor->phone = $item['phone'] ;
                $visitor->company_name = $item['company_name'] ;
                $visitor->email = $item['email'];
                $visitor->appointment_id = $appointment->id; // Get Appoint ID after inserted
                $visitor->save();
            }

            foreach ($appointment->visitors as $visitor) {
                $isExist = in_array($visitor->id, array_column($exisitingVisitorList, 'id'));

                if (!$isExist) {
                    $removeVisitorList[] = $visitor;
                }
            }

            foreach ($removeVisitorList as $key => $value) {
                $remVisitor = Visitor::find($value['id']);
                $remVisitor->delete();
            }

            foreach ($exisitingVisitorList as $key => $item) {
                $editVisitor = Visitor::find($item['id']);
                $editVisitor->name = $item['name'] ;
                $editVisitor->phone = $item['phone'] ;
                $editVisitor->company_name = $item['company_name'] ;
                $editVisitor->email = $item['email'];
                $editVisitor->appointment_id = $appointment->id; // Get Appoint ID after inserted
                $editVisitor->save();

                if ($key == 0) {
                    // Index 0 Name To Update Appointment Visitor Name
                    Appointment::where('id', $appointment->id)->update(['visitor_name'=> $item['name']]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Successfully Updated');
        } catch (QueryException $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Something Went wrong.');
        }

        // return response()->json([
        //     "allNewVisitorList" => $allNewVisitorsList,
        //     "exisitingVisitorList" => $exisitingVisitorList,
        //     "removeVisitorList" => $removeVisitorList,
        // ]);
    }
}
