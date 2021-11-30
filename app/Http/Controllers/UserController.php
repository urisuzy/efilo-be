<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Room;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;

class UserController extends Controller
{
    use ApiResponser;
    public function getUser()
    {
        return $this->successReponse(Auth::user());
    }

    public function getUserAdmin($id)
    {
        $user = User::find($id);
        if ($user)
            return $this->successReponse($user);
        else
            return $this->errorResponse('User Id not found', 404);
    }

    public function addUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'room_code' => 'required',
            'start_date' => 'required|date_format:d-m-Y',
            'end_date' => 'required|date_format:d-m-Y'
        ]);

        DB::beginTransaction();
        try {
            $room = Room::where('code', $request->room_code)->first();

            if (!$room)
                return $this->errorResponse('Room not found', 404);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'room_id' => $room->id,
                'entry_date' => date("Y-m-d H:i:s", strtotime($request->start_date)),
                'out_date' => date("Y-m-d H:i:s", strtotime($request->end_date))
            ]);

            $result = CarbonPeriod::create($request->start_date, '1 month', $request->end_date);
            foreach ($result as $dt) {
                Bill::create([
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'total' => $room->price,
                    'month' => $dt->format('m'),
                    'year' => $dt->format('Y'),
                    'status' => 'unpaid',
                    'pay_date' => null
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
        return $this->successReponse($user);
    }
}
