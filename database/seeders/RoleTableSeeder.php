<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::findOrCreate(config('access.users.admin_role'));

        $admin->givePermissionTo(Permission::all());

        User::find(1)->assignRole(config('access.users.admin_role'));

    }
}
