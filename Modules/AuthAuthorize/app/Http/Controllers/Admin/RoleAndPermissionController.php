<?php

namespace Modules\AuthAuthorize\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\AuthAuthorize\Traits\HttpResponses;
use Modules\AuthAuthorize\Http\Requests\Admin\RoleStoreRequest;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleAndPermissionController extends Controller
{

    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::all();
        return $this->success([
            'role' => $role
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return $this->success([
            'permission' => $permissions
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        $data = $request->validated();
        $role = Role::create(['name' => $request->role, 'guard_name' => 'web'])->givePermissionTo($request->permission);
        return $this->success([
            'data' => $role
        ], 201);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('authauthorize::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $role_permissions = $role->permissions;
        $permissions = Permission::all();
        return $this->success([
            'data' => $role,
            'role_permission' =>  $role_permissions,
            'permissions' =>  $permissions
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $permissions = $role->permissions;
        $role->revokePermissionTo($permissions);
        $role->givePermissionTo($request->permissions);
        $role->update(['name' => $request->role]);
        $role = $role->refresh();
        return $this->success([
            'data' => $role
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $permissions = $role->permissions;
        $role->revokePermissionTo($permissions);
        $role->delete();
        return $this->success([
            'data' => $role
        ], 200);
    }
}
