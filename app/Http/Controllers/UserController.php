<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function addUser()
    {
        //
    }
}
