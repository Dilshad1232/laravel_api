<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserApi;

class UserApiController extends Controller
{
    // 🔹 GET all users
    public function index()
    {
        return response()->json(UserApi::all(), 200);
    }

    // 🔹 GET single user
    public function show($id)
    {
        $user = UserApi::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user, 200);
    }

    // 🔹 POST create new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:user_apis,email',
            'phone' => 'nullable',
        ]);

        $user = UserApi::create($request->all());
        return response()->json(['message' => 'User created successfully', 'data' => $user], 201);
    }

    // 🔹 PUT update user
    public function update(Request $request, $id)
    {
        $user = UserApi::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($request->all());
        return response()->json(['message' => 'User updated successfully', 'data' => $user], 200);
    }

    // 🔹 DELETE user
    public function destroy($id)
    {
        $user = UserApi::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
