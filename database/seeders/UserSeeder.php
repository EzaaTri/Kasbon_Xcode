<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => Hash::make('password123'),
                'role' => 'karyawan',
                'is_approved' => 1,
                'phone' => '1234567890',
                'address' => 'Jl. Contoh No. 1',
                'created_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'password' => Hash::make('password123'),
                'role' => 'karyawan',
                'is_approved' => 1,
                'phone' => '0987654321',
                'address' => 'Jl. Contoh No. 2',
                'created_at' => now(),
            ],
            [
                'name' => 'Craft Hyper',
                'email' => 'crafthyper12@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_approved' => 1,
                'phone' => '1231231234',
                'address' => 'Jl. Admin No. 1',
                'created_at' => now(),
            ],
            [
                'name' => 'Eza A Perdana',
                'email' => 'ezaaperdana@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_approved' => 1,
                'phone' => '5675675678',
                'address' => 'Jl. Admin No. 2',
                'created_at' => now(),
            ],
        ]);
    }
}
