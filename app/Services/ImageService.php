<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function uploadImage($contents)
    {
        $path = Storage::putFile('uploads', $contents);
        return $path;
    }
}
