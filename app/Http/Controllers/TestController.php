<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $imageService = new \App\Services\ImageService();
        echo $imageService->uploadImage($request->file('image'));
    }
}
