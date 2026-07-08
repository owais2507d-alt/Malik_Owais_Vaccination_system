<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Muhammad Owais',
            'email' => 'admin@covid.com',
            'password' => 'admin123',
            'role' => 'admin',
            'phone' => '1234567890',
            'address' => 'Admin Office',
            'location' => 'Headquarters',
        ]);
    }
}
