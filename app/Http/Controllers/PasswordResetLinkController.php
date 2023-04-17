<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request)
    {
        $email = $request->validate([
            'email'    => ['required', 'email'],
        ]);
        $result = Password::broker('users')->sendResetLink($email);
        abort_if($result !== Password::RESET_LINK_SENT,
            Response::HTTP_BAD_REQUEST,
            __($result)
        );
        return response(['data' => __($result)]);
    }
}
