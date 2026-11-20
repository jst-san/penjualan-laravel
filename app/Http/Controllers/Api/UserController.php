<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|min:3', 'email' => 'required|email', 'password' => 'required|string|min:8', 'role' => 'required|in:karyawan,superuser']);

        $user = User::where('email', $validated['email'])->first();

        if ($user) {
            return response()->json(['errors' => ['email' => 'Email ini sudah digunakan', 'code' => 'EMAIL_USED']], 401);
        }

        $hashed = Hash::make($validated['password']);

        $user = User::create(['name' => $validated['name'], 'role' => $validated['role'], 'email' => $validated['email'], 'password' => $hashed]);

        return response()->json(['data' => $user], 201);
    }

    public function index(Request $request)
    {
        $per_page = $request->query("per_page", 10);
        $order_by = $request->query("order_by", "id");
        $search = $request->query("search", "");

        $users = User::whereAny(["name", "email", "role"], "like", "%$search%")->orderBy($order_by)->paginate($per_page);

        return response()->json($users, 200);
    }

    public function show(User $user)
    {
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

    public function updatePicture(Request $request)
    {
        $request->validate(['picture' => 'required|file|mimes:png,jpg,jpeg,webp|max:2048']);

        $picture = $request->file('picture');

        if (!$picture) {
            return response()->json(['errors' => ['picture' => 'Foto tidak boleh kosong']], 400);
        }

        $filename = bin2hex(random_bytes(16)).".{$picture->extension()}";

        $user = $request->user();
        
        $app_url = getenv('APP_URL');

        $prev = str_replace($app_url.'/storage', '', $user->picture);

        Storage::disk('public')->putFileAs('/images/', $picture, $filename);
        
        Storage::disk('public')->delete($prev);

        $user->update(['picture' => $app_url."/storage/images/$filename"]);

        return response()->json(['data' => $user]);
    }
}
