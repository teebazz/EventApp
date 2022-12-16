<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create role Super Admin
        $super_admin = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);
        
        $create_super_admin = User::create([
            'name' => 'Event Manager',
            'email' => 'admin@app.com',
            'password' => Hash::make('password'),
            'phone_number' => '08125812345',
        ])->assignRole('Super Admin');
    }
}
