<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $this->validate($request, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255'],
            'password' => ['required', 'alpha_num:ascii', 'min:6', 'max:12', 'confirmed'], // password_confirmation
            'image'    => ['nullable', 'image',],
        ]);
        abort_if(
            User::where('email', $request->input('email'))->first(),
            Response::HTTP_BAD_REQUEST,
            __('auth.duplicate email')
        );
        DB::beginTransaction();
        try {
            $user = User::create(
                array_merge(
                    $validated, ['password' => Hash::make($validated['password'])]
                )
            );
            if ($request->has('image') && $path = $request->file('image')->store('users')) {
                $user->image()->create([
                    'url' => $path,
                ]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
        return response(['data' => $user]);
    }
}
