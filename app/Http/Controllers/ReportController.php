<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use ApiResponser;
    public function addReport(Request $request)
    {
        try {
            $this->validate($request, [
                'caption' => 'required'
            ]);

            $image = null;
            if (!empty($request->file('file'))) {
                $service = new \App\Services\ImageService;
                $image = $service->uploadImage($request->file('file'));
            }

            $report = Report::create([
                'caption' => $request->caption,
                'image' => $image
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
        return $this->successReponse($report);
    }

    public function list()
    {
        $reports = Report::limit(20)->get();
        return $this->successReponse($reports);
    }

    public function deleteAdmin($id)
    {
        $report = Report::find($id);
        if ($report) {
            $report->delete();
            return $this->successReponse(true);
        }
        return $this->errorResponse('Report not success');
    }
}
