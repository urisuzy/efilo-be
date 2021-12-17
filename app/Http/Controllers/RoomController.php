<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    use ApiResponser;
    public function addRoom(Request $request)
    {
        try {
            $this->validate($request, [
                'code' => 'required',
                'size' => 'required',
                'type' => 'required',
                'price' => 'required',
                'status' => 'required'
            ]);

            $room = Room::create($request->toArray());
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
        return $this->successReponse($room);
    }

    public function list()
    {
        $rooms = Room::with('user')->get();
        return $this->successReponse($rooms);
    }

    public function get($code)
    {
        $room = Room::where('code', $code)->first();
        if ($room)
            return $this->successReponse($room);
        else
            return $this->errorResponse('Code room not found', 404);
    }

    public function update(Request $request)
    {
        try {
            $this->validate($request, [
                'code' => 'required',
                'size' => 'required',
                'type' => 'required',
                'price' => 'required',
                'status' => 'required'
            ]);

            $room = Room::where('code', $request->code)->update($request->toArray());
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
        return $this->successReponse($room);
    }

    public function delete($code)
    {
        $room = Room::where('code', $code)->first();
        if ($room) {
            $room->delete();
            return $this->successReponse(true);
        } else
            return $this->errorResponse('room code not found', 404);
    }
}
