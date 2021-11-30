<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Traits\ApiResponser;
use Exception;

class PostController extends Controller
{
    use ApiResponser;
    public function addPost(Request $request)
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

            $post = Post::create([
                'user_id' => Auth::id(),
                'caption' => $request->caption,
                'image' => $image
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
        return $this->successReponse($post);
    }

    public function list()
    {
        $posts = Post::with(['user.room'])->limit(20)->get();
        return $this->successReponse($posts);
    }

    public function delete(Request $request, $id)
    {
        try {
            $post = Post::find($id);
            if ($post) {
                if ($request->user()->tokenCan('role:admin') or $post->user_id == Auth::id()) {
                    $post->delete();
                    return $this->successReponse(true);
                }
            }
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
        return $this->errorResponse('Report fail, please try again');
    }
}
