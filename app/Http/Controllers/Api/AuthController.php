<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getUser(Request $request)
    {
        return response()->json(['data' => $request->user()]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate(
            ['email' => 'required|email', 'password' => 'required|string|min:8']
        );

        $user = User::where('email', $validated['email'])->firstOrFail();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['errors' => ['form' => 'Kombinasi email dan password salah', 'code' => 'INVALID_CREDENTIALS'], 'password' => $user->password], 402);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data' => ['access_token' => $token, 'user' => $user]], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
