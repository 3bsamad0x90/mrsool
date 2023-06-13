<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create([
            'name_ar' => 'أدمن',
            'name_en' => 'admin',
            'guard' => 'admin'
        ]);
        $userRole = Role::create([
            'name_ar' => 'مستخدم',
            'name_en' => 'user',
            'guard' => 'user'
        ]);
        User::create([
            'name' => 'admin',
            'phone' => '01013014910',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'active' => '1',
            'language' => 'en',
            'gender' => 'male',
            'dob' => '1999-01-20',
            'role_id' => $adminRole->id
        ]);
        User::create([
            'name' => 'user',
            'phone' => '01013014910',
            'email' => 'user@user.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'active' => '1',
            'language' => 'en',
            'gender' => 'male',
            'dob' => '1999-01-20',
            'role_id' => $userRole->id
        ]);
    }
}
