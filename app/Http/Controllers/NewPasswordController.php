<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;

class NewPasswordController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email'    => ['required', 'email'],
            'token'    => ['required', 'string'],
            'password' => [
                'required', 'regex:/^(?=.*[0-9])(?=.*[a-zA-Z])([\w]+)$/u', 'confirmed', PasswordRule::min(6),
            ],
        ]);
        $result = Password::broker('users')->reset($credentials, function (User $user, $password) {
            $user->update([
                'password' => Hash::make($password)
            ]);
        });
        return response(['data' => __($result)]);
        // validate input email, password
        // 先確認 password_resets table 有沒有這個 token及其對應的 user email
        // 透過 email 去找 users table
        // reset password
        // 刪除 password_resets table 裡面的 token
    }
}
