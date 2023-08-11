<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        try {
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $token = $user->createToken('app')->accessToken;
                return response([
                    'message' => __('messages.success'),
                    'token' => $token,
                    'user' => $user
                ], 200);
            }

            return response([
                'message' => __('messages.invalid_credentials')
            ], 401);
        } catch (\Throwable $exception) {
            report($exception);

            return response([
                'message' => __('messages.internal_error')
            ], 500);
        }
    }


    public function Register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $token = $user->createToken('app')->accessToken;
            return response([
                'message' => __('messages.user_created'),
                'token' => $token,
                'user' => $user
            ], 201);

        } catch (\Exception $exception) {
            Log::error('Registration failed: ' . $exception->getMessage());

            return response([
                'message' => __('messages.registration_error')
            ], 500);
        }
    }



}
