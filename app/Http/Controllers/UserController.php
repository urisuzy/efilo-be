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
        return $this->successReponse(User::where('id', Auth::id())->with('room')->first());
    }

    public function getUserAdmin($id)
    {
        $user = User::with('room')->where('id', $id)->first();
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
                'role' => 'member',
                'entry_date' => date("Y-m-d H:i:s", strtotime($request->start_date)),
                'out_date' => date("Y-m-d H:i:s", strtotime($request->end_date))
            ]);

            // $result = CarbonPeriod::create($request->start_date, '1 month', $request->end_date);
            // foreach ($result as $dt) {
            //     Bill::create([
            //         'user_id' => $user->id,
            //         'room_id' => $room->id,
            //         'total' => $room->price,
            //         'month' => $dt->format('m'),
            //         'year' => $dt->format('Y'),
            //         'status' => 'unpaid',
            //         'pay_date' => null
            //     ]);
            // }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
        DB::commit();
        return $this->successReponse($user);
    }

    public function listUsersBill()
    {
        return $this->successReponse(User::with(['room', 'bills'])->get());
    }

    public function listUsers()
    {
        return $this->successReponse(User::with(['room'])->get());
    }

    public function editUser(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            switch ($request->column) {
                case 'password':
                    $user->password = bcrypt($request->value);
                    break;
                case 'entry_date':
                    $user->entry_date = date("Y-m-d H:i:s", strtotime($request->value));
                    break;
                case 'out_date':
                    $user->out_date = date("Y-m-d H:i:s", strtotime($request->value));
                    break;
                case 'name':
                    $user->name = $request->value;
                    break;
                case 'phone_number':
                    $user->phone_number = $request->value;
                    break;
                case 'city':
                    $user->city = $request->value;
                    break;
                case 'address':
                    $user->address = $request->value;
                    break;
                case 'parents_number':
                    $user->parents_number = $request->value;
                    break;
            }
            $user->save();
        } else {
            return $this->errorResponse(false);
        }
        return $this->successReponse($user);
    }
}
