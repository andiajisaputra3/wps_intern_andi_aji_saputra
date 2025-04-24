<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $roles = Role::all();
        return view('masterdata.user-managements.index', compact(['users', 'roles']));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('masterdata.user-managements.user-management-action', compact('user', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'array|exists:roles,name',
        ]);

        $user->syncRoles($request->role);

        return response()->json([
            'status' => 'success',
            'message' => 'Added Roles To User Successfully'
        ]);
    }
}