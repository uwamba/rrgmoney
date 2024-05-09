<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create SperAdmin User
        $user = User::create([
            'first_name'    => 'Super',
            'last_name'     => 'Admin',
            'email'         =>  'Super@admin.com',
            'mobile_number' =>  '+250786138376',
            'address' =>  'Kigali rwanda',
            'country' =>  'Rwanda',
            'password'      =>  Hash::make('Admin@123#'),
            'role_id'       => 1
        ]);
        // Create Admin User
        $user = User::create([
            'first_name'    => 'admin',
            'last_name'     => 'Admin',
            'email'         =>  'admin@admin.com',
            'mobile_number' =>  '+250786138376',
            'address' =>  'Kigali rwanda',
            'country' =>  'Rwanda',
            'password'      =>  Hash::make('Admin@123#'),
            'role_id'       => 6
        ]);
        // Create Finance User
        $user = User::create([
            'first_name'    => 'Finance',
            'last_name'     => 'Admin',
            'email'         =>  'finance@admin.com',
            'mobile_number' =>  '+250786138376',
            'address' =>  'Kigali rwanda',
            'country' =>  'Rwanda',
            'password'      =>  Hash::make('Admin@123#'),
            'role_id'       => 5
        ]);
         // Create Agent User
        $user = User::create([
            'first_name'    => 'Agent',
            'last_name'     => 'Admin',
            'email'         =>  'agent@admin.com',
            'mobile_number' =>  '+250786138376',
            'address' =>  'Kigali rwanda',
            'country' =>  'Rwanda',
            'password'      =>  Hash::make('Admin@123#'),
            'role_id'       => 4
        ]);
    }
}
