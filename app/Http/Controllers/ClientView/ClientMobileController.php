<?php

namespace App\Http\Controllers\ClientView;

use App\Appointment;
use App\Appointmentable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MobileAppointmentRequest;
use App\Service\AppointmentService;
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

        $uabpayUser = $this->appointmentService->checkExistUserAndCreate($request);
        if(!$uabpayUser) {
            return redirect()->back();
        }

        return view('client.mobile-dashboard')
            ->with($this->withGeneralParams($request));
    }

    public function showAppointmentByStatus(Request $request, $status) {
        $statusList =  new Collection(['active', 'request', 'finished']);

        if (!$statusList->contains($status)) {
            return redirect()->back();
        }

        return view('client.mobile-appointments-by-status', [
            'status' => ucfirst($status),
        ]);
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

        $udpateUser = $this->appointmentService->updateUserStatusOfAppointment($user, $appointmentID, $status);

        $data = [
            'appointment_id' => $appointmentID,
            'status' => $validated['status'],
            'request_user' => $udpateUser,
        ];

        // return response()->json($this->withGeneralParams($request, $data));

        return redirect()->back()->with($this->withGeneralParams($request));
    }

    public function showAppointmentDetail(Appointment $appointment_id, Request $request) {
        if (!$this->appointmentService->checkIsValidMobileQueryRequest($request)) {
            return redirect()->back();
        }

        $appointment = $appointment_id->load(['visitors', 'staffs', 'branch']);
        $allInvitedPersons = array_merge($appointment->visitors->toArray(), $appointment->staffs->toArray());
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

    public function showJoinAppointment() {
        return view('client.mobile-join-appointment', []);
    }

    public function showMakeAppointment(Request $request) {
        if (!$this->appointmentService->checkIsValidMobileQueryRequest($request)) {
            return redirect()->back();
        }

        $user = $this->appointmentService->checkExistUserAndCreate($request);
        if(!$user) {
            return redirect()->back();
        }

        return view('client.mobile-make-appointment')->with(
            $this->withGeneralParams($request, ['user' => $user])
        );
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
        // $newVisitor = $this->appointmentService->createVisitorForVisitor($name, $phoneNo);

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
