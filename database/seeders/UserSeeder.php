<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'name' => 'admin admin',
            'email' => 'admin@admin.com',
            'role'=>'admin',
            'slug'=>'admin-admin',
            'photo'=>'web/avatar/user.png',
            'active'=>1,
            'password' => Hash::make('12345678'),
        ]);
    }
}
