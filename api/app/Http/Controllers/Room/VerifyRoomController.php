<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Room\VerifyRoomRequest;
use App\Repositories\Room\RoomRepositoryInterface;
use App\Repositories\RoomConfirmation\RoomConfirmationRepositoryInterface;
use Carbon\Carbon;
use App\Models\RoomConfirmation;

class VerifyRoomController extends Controller
{
    private $roomRepository;
    private $roomConfirmationRepository;

    public function __construct(
        RoomRepositoryInterface $roomRepository,
        RoomConfirmationRepositoryInterface $roomConfirmationRepository
    ) {
        $this->roomRepository = $roomRepository;
        $this->roomConfirmationRepository = $roomConfirmationRepository;
    }

    public function verifyRoom(VerifyRoomRequest $request)
    {
        $room_id = $request->room_id;
        $collaborator_id = auth('collaborator')->user()->id;

        $room = $this->roomRepository->find($room_id);
        $owner_id = $room->inn->owner_id;
        
        try {
            $room->verified = 1;
            $room->verified_at = Carbon::now()->format('Y-m-d H:i:s');
            $room->save();

            $this->roomConfirmationRepository->create([
                'room_id' => $room->id,
                'owner_id' => $owner_id,
                'status' => RoomConfirmation::ACCEPT_ROOM,
                'confirmed_by' => $collaborator_id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong!'
            ]);
        }

        return response()->json([
            'message' => "Xac thuc phong thanh cong"
        ], 200);
    }

    public function rejectRoom(Request $request)
    {
        $room_id = $request->room_id;
        $collaborator_id = auth('collaborator')->user()->id;

        $room = $this->roomRepository->find($room_id);
        $owner_id = $room->inn->owner_id;

        if ($room->status == 0) {
            return response()->json([
                'message' => 'Phong da duoc huy bo roi'
            ], 400);
        }
        
        try {
            $room->verified = 0;
            $room->verified_at = null;
            $room->status = 0;
            $room->save();

            $this->roomConfirmationRepository->create([
                'owner_id' => $owner_id,
                'room_id' => $room->id,
                'status' => RoomConfirmation::REJECT_ROOM,
                'reject_description' => $request->reject_description,
                'confirmed_by' => $collaborator_id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 502);
        }

        return response()->json([
            'message' => 'Thanh cong'
        ], 200);
    }
}
