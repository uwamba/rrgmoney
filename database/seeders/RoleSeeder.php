<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'SuperAdmin',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'User',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Customer',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Agent',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Finance',
            'guard_name' => 'web',
        ]);
        Role::create([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);
    }
}
