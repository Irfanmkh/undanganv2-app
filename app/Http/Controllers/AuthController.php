<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Login Gagal, pastikan email dan password benar'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login Berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }

    public function register(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Register Berhasil',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout Berhasil'
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            "current_password" => 'required|string',
            "new_password" => "required|string|min:8|confirmed"

        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                "message" => "password tidak sesuai!",

            ], 422);
        }

        if ($request->current_password === $request->new_password) {
            return response()->json([
                "message" => "password baru tidak boleh sama dengan password lama!",

            ], 422);
        }

        $user->update([
            "password" => bcrypt($request->new_password)
        ]);
        return response()->json([
            "message" => "password berhasil diubah!"
        ], 200);
    }
}
