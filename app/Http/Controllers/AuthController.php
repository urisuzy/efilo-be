<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;
    public function login(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication was successful...
            $user = User::find(Auth::id());
            if ($user->role == 'admin') {
                $createToken = $user->createToken('efillokos', ['role:admin']);
            } else {
                $createToken = $user->createToken('efillokos', ['role:user']);
            }

            // $result['token'] = $createToken->token;
            $result['accessToken'] = $createToken->plainTextToken;
            $result['role'] = $user->role;

            return $this->successReponse($result);
        } else {
            return $this->errorResponse('Email atau password salah');
        }
    }
}
