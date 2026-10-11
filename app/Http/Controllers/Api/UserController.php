<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function current(Request $request)
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

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|min:3', 'email' => 'required|email', 'password' => 'required|string|min:8']);

        $user = User::where('email', $validated['email'])->first();

        if ($user) {
            return response()->json(['errors' => ['email' => 'Email ini sudah digunakan', 'code' => 'EMAIL_USED']], 401);
        }

        $hashed = Hash::make($validated['password']);

        $user = User::create(['name' => $validated['name'], 'email' => $validated['email'], 'password' => $hashed]);

        return response()->json(['data' => $user], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }

    public function index(Request $request)
    {
        $per_page = $request->query("per_page", 10);
        $order_by = $request->query("order_by", "id");

        $users = User::orderBy($order_by)->paginate($per_page);

        return response()->json($users, 200);
    }

    public function show(User $user) {
        return response()->json(['data' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|min:3',
                'email' => 'required|email',
            ]
        );

        $user->update(['name' => $validated['name'], 'email' => $validated['email']]);

        return response()->json(['data' => $user]);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
