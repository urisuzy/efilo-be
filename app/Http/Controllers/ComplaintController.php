<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    use ApiResponser;
    public function addComplaint(Request $request)
    {
        try {
            $this->validate($request, [
                'caption' => 'required'
            ]);

            $image = null;
            if (!empty($request->file('image'))) {
                $service = new \App\Services\ImageService;
                $image = $service->uploadImage($request->file('image'));
            }

            $complaint = Complaint::create([
                'user_id' => Auth::id(),
                'caption' => $request->caption,
                'image' => $image,
                'status' => 'new'
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
        return $this->successReponse($complaint);
    }

    public function list()
    {
        $complaints = Complaint::where('user_id', Auth::id())->with(['user.room'])->limit(20)->get();
        return $this->successReponse($complaints);
    }

    public function delete(Request $request, $id)
    {
        try {
            $complaint = Complaint::find($id);
            if ($complaint) {
                if ($request->user()->tokenCan('role-admin') or $request->user_id == Auth::id()) {
                    $complaint->delete();
                    return $this->successReponse(true);
                }
            }
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
        return $this->errorResponse('Complaint fail, please try again');
    }

    public function listAdmin()
    {
        $complaints = Complaint::with(['user.room'])->limit(20)->get();
        return $this->successReponse($complaints);
    }

    public function updateAdmin(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'status' => 'required'
        ]);

        $complaint = Complaint::find($request->id);
        if ($complaint) {
            $complaint->status = $request->status;
            $complaint->save();
        } else {
            return $this->errorResponse('Post Id not found', 404);
        }
        return $this->successReponse($complaint);
    }
}
