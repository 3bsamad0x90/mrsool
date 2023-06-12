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
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'phone' => '01013014910',
            'email_verified_at' => now(),
            'role_id' => $adminRole->id
        ]);
        User::create([
            'name' => 'user',
            'username' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'phone' => '01013014910',
            'email_verified_at' => now(),
            'role_id' => $userRole->id
        ]);
    }
}
