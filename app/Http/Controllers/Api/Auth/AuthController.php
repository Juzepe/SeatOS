<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create(array_merge(
            $request->validated(),
            [
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
            ],
        ));

        return response()->json([
            'message' => 'User registered successfully. You can now login.',
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 401);
        }

        return response()->json([
            'message' => 'User logged in successfully.',
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken,
        ]);
    }
}
