<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    use ApiResponser;
    public function update(Request $request)
    {
        $this->validate($request, [
            'room_id' => 'required',
            'user_id' => 'required',
            'total' => 'required',
            'month' => 'required',
            'year' => 'required',
        ]);

        Bill::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'room_id' => $request->room_id,
                'month' => $request->month,
                'year' => $request->year,
            ],
            [
                'total' => $request->total,
                'status' => 'paid',
                'pay_date' => date("Y-m-d H:i:s")
            ]
        );
        return $this->successReponse(true);
        // $bill = Bill::find($request->id);
        // if ($bill) {
        //     $bill->status = $request->status;
        //     $bill->save();
        //     return $this->successReponse($bill);
        // } else
        //     return $this->errorResponse('bill tidak ditemukan');
    }

    public function list()
    {
        return $this->successReponse(Bill::where('user_id', Auth::id())->get());
    }
}
