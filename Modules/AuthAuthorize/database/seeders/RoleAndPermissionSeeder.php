<?php

namespace Modules\AuthAuthorize\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayOfPermissionNames = [
            'user create',
            'user view',
            'user edit',
            'user delete',
            'teacher create',
            'teacher view',
            'teacher edit',
            'teacher delete',
            'student create',
            'student view',
            'student edit',
            'student delete',
            'class create',
            'class view',
            'class edit',
            'class delete',
            'attendance create',
            'attendance view',
            'attendance edit',
            'attendance delete',
            'grade create',
            'grade view',
            'grade edit',
            'grade delete',
            'assignment create',
            'assignment view',
            'assignment edit',
            'assignment delete',
            'exam create',
            'exam view',
            'exam edit',
            'exam delete',
            'payment create',
            'payment view',
            'payment edit',
            'payment delete',
        ];

        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });
        Permission::insert($permissions->toArray());
        $role = Role::create(["name" => "Admin"])
            ->givePermissionTo($arrayOfPermissionNames);
    }
}
