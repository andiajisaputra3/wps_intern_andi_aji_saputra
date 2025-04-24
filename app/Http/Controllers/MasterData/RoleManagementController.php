<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->get();
        $permissions = Permission::all();
        return view('masterdata.role-managements.index', compact(['roles', 'permissions']));
    }

    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        return view('masterdata.role-managements.role-management-action', compact(['role', 'permissions']));
    }

    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'permission' => 'array|exists:permissions,name',
        ]);

        $role->syncPermissions($request->permission);

        return response()->json([
            'status' => 'success',
            'message' => 'Added Permission To Role Successfully'
        ]);
    }
}