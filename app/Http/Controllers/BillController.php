<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class BillController extends Controller
{
    use ApiResponser;
    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'status' => 'required'
        ]);

        $bill = Bill::find($request->id);
        if ($bill) {
            $bill->status = $request->status;
            $bill->save();
            return $this->successReponse($bill);
        } else
            return $this->errorResponse('bill tidak ditemukan');
    }
}
