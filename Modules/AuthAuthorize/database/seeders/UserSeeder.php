<?php

namespace Modules\AuthAuthorize\Database\Seeders;

use Illuminate\Database\Seeder;
use  Modules\AuthAuthorize\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123@@##')
        ]);

        $user->assignRole('admin');
    }
}
