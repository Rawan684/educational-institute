<?php

namespace Modules\AuthAuthorize\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\AuthAuthorize\Traits\HttpResponses;
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
        return view('authauthorize::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authauthorize::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->role, 'guard_name' => 'web'])->givePermissionTo($request->permission);
        return $this->success([
            'role' => $role
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
        return view('authauthorize::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
