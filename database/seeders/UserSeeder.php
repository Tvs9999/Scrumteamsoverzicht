<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstname' => 'Frans',
            'lastname' => 'de Boer',
            'email' => 'fdeboer@rocfriesepoort.nl',
            'role' => 1,
            'present' => 0, 
            'activation_key' => bin2hex(openssl_random_pseudo_bytes(16)), 
            'password' => Hash::make('Pass#123'),
            // Add other columns as needed
        ]);
    }
}
