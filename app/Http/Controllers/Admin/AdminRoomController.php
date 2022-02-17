<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Branch;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRoomFormRequest;
use App\Room;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    //

    public function showRooms(Request $request) {
        $roomQuery = Room::with(['branch']);

        $branchQuery = $request->query('branch_id');
        if ($branchQuery) {
            $roomQuery->where('branch_id', $branchQuery);
        }

        $statusQuery = $request->query('status');
        if ($statusQuery) {
            $roomQuery->where('status', $statusQuery);
        }

        $rooms = $roomQuery->orderBy('id', 'DESC')->paginate(15);
        $branches = Branch::all();

        return view('admin.room.room-view', [
            'navTitle' => "Room",
            'rooms' => $rooms,
            'branches' => $branches,
            'branchQuery' => $branchQuery,
            'statusQuery' => $statusQuery,
            'statusList' => Room::$APPOINTMENT_STATUS_TYPE,
        ]);
    }

    public function showAppointmentRooms(Request $request) {
        $roomQuery = Room::with(['branch']);

        $branchQuery = $request->query('branch_id');
        if ($branchQuery) {
            $roomQuery->where('branch_id', $branchQuery);
        } else {
            $roomQuery->where('branch_id', 1);
            $branchQuery = 1;
        }

        $rooms = $roomQuery->orderBy('id', 'ASC')->get();
        $branches = Branch::all();

        return view('admin.room.room-appointment-view', [
            'navTitle' => "Room",
            'rooms' => $rooms,
            'branches' => $branches,
            'branchQuery' => $branchQuery,
            'statusList' => Room::$APPOINTMENT_STATUS_TYPE,
        ]);
    }

    public function showRoomDetail(Room $id) {
        $room = $id->load(['branch']);

        if ($room->status === 2) {
            $current_appointment = Appointment::where('room_id', $room->id)->latest()->first();
        }

        $responseData = [
            'navTitle' => 'Room Detail',
            'room' => $room,
            'current_appointment' => $current_appointment ?? null,
        ];

        // return response()->json($responseData);

        return view('admin.room.room-detail', $responseData);
    }

    public function showRoomEditDetail(Room $id) {
        $room = $id->load(['branch']);
        $branches = Branch::with('township')->get();

        return view('admin.room.room-edit', [
            'navTitle' => 'Room Edit',
            'branches' => $branches,
            'room' => $room,
        ]);
    }

    public function showCreateForm() {
        $branches = Branch::with('township')->get();

        response()->json($branches);
        return view('admin.room.room-create', [
            'navTitle' => 'Room Create',
            'branches' => $branches,
        ]);
    }


    public function submitEdit(AdminRoomFormRequest $request, $id) {
        $validated = $request->validated();

        $room = Room::find($id);
        $room->fill($validated)->save();

        return back()->with(
            'success',  'Successfully Updated '
        );
    }

    public function submitCreate(AdminRoomFormRequest $request) {
        $validated = $request->validated();

        $room = new Room();
        $room->fill($validated)->save();

        return redirect()->route('admin.rooms.index')->with(
            'success',  'Successfully Created ' . $room->room_name . ' (' . $room->branch->branch_name . ')'
        );
    }

    public function deleteRoom(Room $id) {
        $room = $id;
        $room->delete();
        return back()->with('success', 'Successfully Deleted ' . $room->room_name );
    }

    public function restoreRoom(Request $request) {
        $room = Room::withTrashed()->where('id', $request->id)->first();
        $room->restore();
        // return redirect()->route('admin.data.staff')->with('success', 'Successfully Restore ' . $staff->name . ' (' . $staff->email . ')');
        return back()->with('success', 'Restore this room');
    }
}
