<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserManagementController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => User::select('id', 'name', 'email')->with('roles')->get()
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'string']
        ]);

        $user->syncRoles([$request->role]);

        return response()->json([
            'message' => '✅ Role updated successfully',
            'user' => $user->load('roles')
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return response()->json(['user' => $user->load('roles')]);
    }


    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }


    public function getPermissions()
    {
        return response()->json([
            'permissions' => Permission::pluck('name') // فقط الأسماء
        ]);
    }
}
