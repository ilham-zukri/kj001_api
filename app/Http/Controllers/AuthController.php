<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'nim' => 'required',
            'name' => 'required',
            'password' => 'required'
        ]);

        $user = User::create([
            'nim' => $request->nim,
            'name' => $request->name,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'Berhasil membuat akun'], 201);
    }

    public function login(Request $request): JsonResponse
    {

        $request->validate([
            'nim' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('nim', $request->nim)->first();

        if (!$user && !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Credential does not match'], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "message" => "Login Berhasil",
            "token" => $token
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = User::whereId($request->user()->id)->first();
        $user->tokens()->delete();

        return response()->json([
            "message" => "Logout Berhasil",
        ]);
    }
}
