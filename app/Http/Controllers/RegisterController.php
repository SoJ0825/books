<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $this->validate($request, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required', 'alpha_num:ascii', 'min:6', 'max:12', 'confirmed'], // password_confirmation
        ]);
        abort_if(
            User::where('email', $request->input('email'))->first(),
            Response::HTTP_BAD_REQUEST,
            __('auth.duplicate email')
        );
        $user = User::create(
            array_merge(
                $validated, ['password' => Hash::make($validated['password'])]
            )
        );
        return response(['data' => $user]);
    }
}
