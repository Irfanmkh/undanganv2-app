<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    //

    public function index()
    {
        if (auth()->user()->isSuperAdmin()) {
            $data_user = User::all();

            return response()->json([
                'message' => 'Users retrieved successfully',
                'data' => $data_user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 403);
        }
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'email' => 'email|required|unique:users',
            'name' => 'string|required|unique:users',
            'password' => 'string|required|min:8',
            'role' => 'string|required|in:super_admin,pengantin'
        ]);

        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        return response()->json([
            'message' => 'superAdmin created successfully',
            'data' => $user
        ], 201);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'email|sometimes|required',
            'name' => 'string|sometimes|required',
            'password' => 'string|sometimes|required|min:8',
            'role' => 'string|sometimes|required|in:super_admin,pengantin'
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        $user->update([
            'email' => $request->email ?? $user->email,
            'name' => $request->name ?? $user->name,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'role' => $request->role ?? $user->role
        ]);

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ], 200);
    }
}
