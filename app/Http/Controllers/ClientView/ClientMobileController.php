<?php

namespace App\Http\Controllers\ClientView;

use App\Appointment;
use App\Appointmentable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MobileAppointmentRequest;
use App\Service\AppointmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ClientMobileController extends Controller
{
    //
    public $appointmentService;

    public function __construct()
    {
        $this->appointmentService = new AppointmentService();
    }

    public function showDashboard(Request $request) {
        if (!$this->appointmentService->checkIsValidMobileQueryRequest($request)) {
            return redirect()->back();
        }

        $startOfDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endOfDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        $next30Days = Carbon::now()->addDays(30)->endOfDay()->format('Y-m-d H:i:s');
        $last30Days = Carbon::today()->startOfMonth()->subMonth(3)->format('Y-m-d H:i:s');
        $pendingStatus = Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'];
        $finishedStatus = Appointment::$APPOINTMENT_STATUS_TYPE['FINISHED'];
        $userRequestStatus = Appointment::$USER_STATUS['REQUEST'];
        $userActiveStatus = Appointment::$USER_STATUS['GOING'];

        $uabpayUser = $this->appointmentService->checkExistUserAndCreate($request);
        if(!$uabpayUser) {
            return redirect()->back();
        }

        // 1.First Get Pending Appointments and Filter Rquest, And Acites
        $pendingAppointments = $this->appointmentService->getAppointmentListForuabPay($uabpayUser, $pendingStatus, $startOfDay, $next30Days);
        $requestAppointments = $this->appointmentService->getUserAppointmentWithStatusForPay($uabpayUser, $pendingAppointments, $userRequestStatus);
        $activeAppointments = $this->appointmentService->getUserAppointmentWithStatusForPay($uabpayUser, $pendingAppointments, $userActiveStatus);
        // 2. Get Finished Appointments
        $finishedAppointment = $this->appointmentService->getAppointmentListForuabPay($uabpayUser, $finishedStatus, $last30Days, $endOfDay);
        // 3. Get Today Pending Appointments
        $todayAppointments = $this->appointmentService->getAppointmentListForuabPay($uabpayUser, $pendingStatus, $startOfDay, $endOfDay);

        $data = [
            'date' => $startOfDay,
            'last30Days' => $last30Days,
            'user' => $uabpayUser,
            'todayAppointments' => $todayAppointments,
            'todayAppointmentsCount' => count($todayAppointments),
            'requestAppointments' => $requestAppointments,
            'requestAppointmentsCount' => count($requestAppointments),
            'activeAppointments' => $activeAppointments,
            'activeAppointmentsCount' => count($activeAppointments),
            'finishedAppointment' => $finishedAppointment,
            'finishedAppointmentCount' => count($finishedAppointment),
        ];

        // return response()->json($data);

        return view('client.mobile-dashboard')
            ->with($this->withGeneralParams($request, $data));
    }

    public function showAppointmentByStatus(Request $request, $status) {
        $statusList =  new Collection(['active', 'request', 'finished']);

        if (!$statusList->contains($status)) {
            return redirect()->back();
        }

        if (!$this->appointmentService->checkIsValidMobileQueryRequest($request)) {
            return redirect()->back();
        }

        $startOfDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endOfDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        $next60Days = Carbon::now()->addDays(60)->endOfDay()->format('Y-m-d H:i:s');
        $last30Days = Carbon::today()->startOfMonth()->subMonth(3)->format('Y-m-d H:i:s');
        $pendingStatus = Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'];
        $finishedStatus = Appointment::$APPOINTMENT_STATUS_TYPE['FINISHED'];
        $userRequestStatus = Appointment::$USER_STATUS['REQUEST'];
        $userActiveStatus = Appointment::$USER_STATUS['GOING'];

        $uabpayUser = $this->appointmentService->checkExistUserAndCreate($request);
        if(!$uabpayUser) {
            return redirect()->back();
        }
        $appointmentData = [];

        if ($status === 'finished') {
            // 1. Get Finished Appointments
            $appointmentData = $this->appointmentService->getAppointmentListForuabPay($uabpayUser, $finishedStatus, $last30Days, $endOfDay);
        } else {
            // 1.First Get Pending Appointments and Filter Rquest, And Acites
            $pendingAppointments = $this->appointmentService->getAppointmentListForuabPay($uabpayUser, $pendingStatus, $startOfDay, $next60Days);
            if ($status === 'request') {
                $appointmentData = $this->appointmentService->getUserAppointmentWithStatusForPay($uabpayUser, $pendingAppointments, $userRequestStatus);
            } else {
                $appointmentData = $this->appointmentService->getUserAppointmentWithStatusForPay($uabpayUser, $pendingAppointments, $userActiveStatus);
            }
        }

        $data = [
            'date' => $startOfDay,
            'last30Days' => $last30Days,
            'appointmentData' => $appointmentData,
            'appointmentDataCount' => count($appointmentData),
            'status' => ucfirst($status),
        ];

        // return response()->json($this->withGeneralParams($request, $data));

        return view('client.mobile-appointments-by-status', $this->withGeneralParams($request, $data));
    }

    public function updateAttendanceStatus(Appointment $appointment_id, Request $request) {
        if (!$this->appointmentService->checkIsValidMobileQueryRequest($request)) {
            return redirect()->back();
        }
        $user = $this->appointmentService->checkExistUserAndCreate($request);
        $appointmentID = $appointment_id->id;
        $validated = $request->validate([
            'status' => 'string|required'
        ]);

        $status = $validated["status"] == "2" ? 2 : 3;

        $this->appointmentService->updateUserStatusOfAppointment($user, $appointmentID, $status);

        return redirect()->back()->with($this->withGeneralParams($request));
    }

    public function showAppointmentDetail(Appointment $appointment_id, Request $request) {
        if (!$this->appointmentService->checkIsValidMobileQueryRequest($request)) {
            return redirect()->back();
        }

        $appointment = $appointment_id->load(['visitors', 'staffs', 'branch']);
        $allInvitedPersons = array_merge($appointment->staffs->toArray(), $appointment->visitors->toArray());
        $organizer = $this->appointmentService->getOrganizerWithPivot($appointment->visitors, $appointment->staffs);
        $showInvitedPerson = $this->appointmentService->organizerFilterList($allInvitedPersons, $organizer);
        $currentAccount = $this->appointmentService->getCurrentAccount($request);
        $currentAccount = $this->appointmentService->getCurrentAccountStatusInfo($allInvitedPersons, $currentAccount);

        $data = [
            'appointment' => $appointment,
            'organizer' => $organizer,
            'invited_person_count' => count($showInvitedPerson),
            'invited_person' => $showInvitedPerson,
            'current_account' => $currentAccount,
        ];

        // return response()->json($this->withGeneralParams($request, $data));

        return view('client.mobile-appointment-detail')->with($this->withGeneralParams($request, $data));
    }

    public function showSnoozeAppointment($appointment_id) {
        $status = $appointment_id == 1 ? 'active' : 'pending';

        return view('client.mobile-appointment-snooze', [
            'appointment_id' => $appointment_id,
            'status' =>  ucfirst($status),
        ]);
    }

    public function showJoinAppointment(Request $request) {
        if (!$this->appointmentService->checkIsValidMobileQueryRequest($request)) {
            return redirect()->back();
        }

        return view('client.mobile-join-appointment', $this->withGeneralParams($request));
    }

    public function submitJoinAppointment(Request $request) {
        $validated = $request->validate([
            'appointment_id' => 'string|required'
        ]);

        $uabpayUser = $this->appointmentService->checkExistUserAndCreate($request);
        if(!$uabpayUser) {
            return redirect()->back()->with('error', 'User is not found.');
        }

        $appointmentID = $validated['appointment_id'];
        $appointment = Appointment::with(['staffs', 'visitors'])->find($appointmentID);
        if (!$appointment) {
            return redirect()->back()->with('error', 'Your appointment was not found.');
        }

        $isOccupied = $appointment->status === Appointment::$APPOINTMENT_STATUS_TYPE['OCCUPIED'];
        $isPending = $appointment->status === Appointment::$APPOINTMENT_STATUS_TYPE['PENDING'];

        if ( !($isOccupied || $isPending) ) {
            return redirect()->back()->with('error', 'Your appointment was Finished.');
        }

        $currentAccount = $this->appointmentService->getCurrentAccount($request);
        $isAlreadyAttach = $this->appointmentService->checkUserIsAlreadyAttachForJoin($currentAccount, $appointmentID);

        if ($isAlreadyAttach) {
            return redirect()->route('client.appointmen-detail', $this->withGeneralParamsExtract($request, ['appointment_id' => $appointmentID]));
        }

        $this->appointmentService->attachJoinAppointmentWithGoing($currentAccount, $appointmentID);

        return redirect()->route('client.appointmen-detail', $this->withGeneralParamsExtract($request, ['appointment_id' => $appointmentID]));
    }

    public function showMakeAppointment(Request $request) {
        if (!$this->appointmentService->checkIsValidMobileQueryRequest($request)) {
            return redirect()->back();
        }

        $user = $this->appointmentService->checkExistUserAndCreate($request);
        if(!$user) {
            return redirect()->back();
        }

        $data = [
            'user' => $user,
        ];

        return view('client.mobile-make-appointment')->with($this->withGeneralParams($request, $data));
    }

    public function withGeneralParams(Request $request, $mergeArray = []) {

        $generalParams = [
            'generalParams' => [
                'name' => $request->query('name'),
                'phone' => $request->query('phone')
            ]
        ];

        return array_merge($mergeArray, $generalParams);
    }

    public function withGeneralParamsExtract(Request $request, $mergeArray = []) {
        $generalParams = [
            'name' => $request->query('name'),
            'phone' => $request->query('phone')
        ];

        return array_merge($mergeArray, $generalParams);
    }

    // All Response API

    public function checkInvitorWithPhone(Request $request) {
        $validated = $request->validate([
            'phone' => 'string|required'
        ]);
        $phone = $validated['phone'];

        $uabpayUser = $this->appointmentService->checkIsUabpayUser($phone);

        if (!$uabpayUser) {
            return response()->json(['isSuccess' => false]);
        }

        $staff = $this->appointmentService->checkIsExistStaffByPhone($phone);
        if ($staff) {
            return response()->json(['isSuccess' => true, 'data' => $staff, 'type' => 'staff']);
        }

        $visitor = $this->appointmentService->checkIsExistVisitorByPhone($phone);
        if ($visitor) {
            return response()->json(['isSuccess' => true, 'data' => $visitor, 'type' => 'visitor']);
        }

        // There is not both staff and visitor , we make new visitor
        // $newVisitor = $this->appointmentService->creaetVisitor($name, $phoneNo);

        return response()->json(['isSuccess' => false, 'data' => null]);
    }

    public function appointmentSubmitFromUabpay(MobileAppointmentRequest $request) {
        $validated = $request->validated();
        $appointment = $this->appointmentService->makeAppointment($validated);

        if (!$appointment) {
            return response()->json(['isSuccess' => false, 'data' => null]);
        }

        return response()->json(['isSuccess' => true, 'data' => $appointment]);
    }



}
