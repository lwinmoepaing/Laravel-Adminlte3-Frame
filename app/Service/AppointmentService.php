<?php
namespace App\Service;

use App\Appointment;
use App\Appointmentable;
use App\Staff;
use App\Visitor;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentService {


    public function checkIsValidMobileQueryRequest(Request $request)
    {
        if ($request->query('phone') && $request->query('name')) {
            return true;
        }
        return false;
    }

    public function checkExistUserAndCreate(Request $request)
    {
        $phoneNo = $request->query('phone');
        $name = $request->query('name');
        $isUabpayUser = $this->checkIsUabpayUser($phoneNo);

        if (!$isUabpayUser) {
            return false;
        }

        $isStaffAcc = $this->checkIsExistStaffByPhone($phoneNo);
        if ($isStaffAcc) {
            return $isStaffAcc;
        }

        $isAlreadyVisitor = $this->checkIsExistVisitorByPhone($phoneNo);
        if (!$isAlreadyVisitor) {
            return $this->createVisitorForVisitor($name, $phoneNo);
        }

        return $isAlreadyVisitor;
    }

    public function getCurrentAccount(Request $request)
    {

        $phoneNo = $request->query('phone');
        $isStaffAcc = $this->checkIsExistStaffByPhone($phoneNo);
        if ($isStaffAcc) {
            return $isStaffAcc;
        }

        $visitor = $this->checkIsExistVisitorByPhone($phoneNo);
        if ($visitor) {
            return $visitor;
        }

        return null;
    }


    public function checkIsUabpayUser($phone)
    {
        return true;
    }

    public function checkIsExistStaffByPhone($phone) {
        $staff = Staff::where('phone', $phone)->first();
        return $staff ? $staff : false;
    }

    public function checkIsExistVisitorByPhone($phone) {
        $visitor = Visitor::where('phone', $phone)->first();
        return $visitor ? $visitor : false;
    }

    public function createVisitorForVisitor($name, $phone, $email = '') {
        $newVisitor = new Visitor();
        $newVisitor->fill(['name' => $name, 'phone' => $phone, 'email' => $email, 'company_name' => '']);
        $newVisitor->save();
        return $newVisitor;
    }

    public function makeAppointment($data) {
        DB::beginTransaction();
        try {
            $organizer = $this->getOrganizer($data['invite_persons']);

            $appointment = new Appointment();
            $appointment->title = $data['title'];
            $appointment->meeting_request_time = new DateTime($data['date'] . ' ' . $data['time']);
            $appointment->branch_id = $data['branch'];
            $appointment->status = 1;
            $appointment->create_type = $organizer['type'] == 'visitor' ? 1 : 3;
            $appointment->organizer_name = $organizer['name'] ? $organizer['name'] : '';
            $appointment->save();

            $visitorList = $this->getVisitorList($data['invite_persons']);
            $staffList = $this->getStaffList($data['invite_persons']);

            foreach ($visitorList as $key => $eachVisitor) {
                $visitor = Visitor::find($eachVisitor['id']);
                $visitor
                    ->appointments()
                    ->attach([
                        $appointment->id =>
                            [
                                'is_organizer' => $eachVisitor['is_organizer'],
                                'status' => $eachVisitor['is_organizer'] ? 2 : 1
                            ]
                        ]
                    );
            }

            foreach ($staffList as $key => $eachStaff) {
                $staff = Staff::find($eachStaff['id']);
                $staff
                    ->appointments()
                    ->attach([
                        $appointment->id =>
                            [
                                'is_organizer' => $eachStaff['is_organizer'],
                                'status' => $eachStaff['is_organizer'] ? 2 : 1,
                                'department_id' => $staff->department_id
                            ]
                        ]
                    );
            }

            DB::commit();
            return $appointment;
        } catch (QueryException $e){
            DB::rollBack();
            dd($e->getMessage());
            return false;
        }
    }

    public function getOrganizer($invitedPerson) {
        $organizer = null;
        foreach($invitedPerson as $person) {
            if (isset($person['is_organizer'])) {
                $organizer = $person;
            }
        }

        return $organizer;
    }

    public function getOrganizerWithPivot($invitedStaffPerson, $invitedVisitiorPerson) {
        $organizer = null;
        foreach($invitedStaffPerson as $person) {
            if ($person->pivot->is_organizer) {
                $organizer = $person;
            }
        }

        foreach($invitedVisitiorPerson as $person) {
            if ($person->pivot->is_organizer) {
                $organizer = $person;
            }
        }
        return $organizer;
    }

    public function getVisitorList($invitedPerson) {
        $visitors = [];
        foreach($invitedPerson as $person) {
            if (isset($person['is_organizer'])) {
                $person['is_organizer'] = 1;
            } else {
                $person['is_organizer'] = false;
            }

           if ($person['type'] == 'visitor') {
               $visitors[] = $person;
           }
        }
        return $visitors;
    }

    public function getStaffList($invitedPerson) {
        $staffs = [];
        foreach($invitedPerson as $person) {
            if (isset($person['is_organizer'])) {
                $person['is_organizer'] = 1;
            } else {
                $person['is_organizer'] = false;
            }
           if ($person['type'] == 'staff') {
               $staffs[] = $person;
           }
        }
        return $staffs;
    }


    public function getCurrentAccountStatusInfo($allInvitedPersons, $currentAccount) {
        $currentInfo = null;
        foreach ($allInvitedPersons as $key => $value) {
            if ($value['type'] == $currentAccount->type && $value['id'] == $currentAccount->id) {
                $currentInfo = $value;
                if(isset($currentInfo['pivot']['status'])) {
                    $currentInfo['appointment_status'] = $currentInfo['pivot']['status'] == 2 ? 'Active' : 'Request';
                }
            }
        }
        return $currentInfo;
    }

    public function organizerFilterList($invitedPersons, $organizer) {
        $list = [];
        foreach($invitedPersons as $value) {
            $organizerCondition = $value['id'] == $organizer->id && $value['type'] == $organizer->type;
            if (!$organizerCondition) {
                $list[] = $value;
            }
        }
        return $list;
    }

    public function getAppointmentStatusName($status) {
        switch ($status) {
            case 1:
                return 'Pending';
            case 2:
                return 'Going';
            case 3:
                return 'Can\'t Go';
            default:
               return 'Default';
        }
    }

    public function updateUserStatusOfAppointment($user, $appointment_id, $status) {
        $userModelType = $user->type == 'staff' ? "App\Staff" : "App\Visitor";
        $data = Appointmentable::where('appointmentable_type', $userModelType)
            ->where('appointment_id', $appointment_id)
            ->where('appointmentable_id', $user->id)
            ->first();
        $data->status = $status;
        $data->save();
        return $data;
    }
}
