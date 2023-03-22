<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credential = $this->validate($request, [
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required', 'alpha_num', 'min:6', 'max:12'],
        ]);
        $token = Auth::attempt($credential);
        abort_if(!$token, Response::HTTP_BAD_REQUEST, '帳號密碼錯誤');
        return response(['data' => $token]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->noContent();
    }
}
