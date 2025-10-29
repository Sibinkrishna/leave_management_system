<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Sibin Krishna',
            'email' => 'sibin123@gmail.com',
            'password' =>Hash::make('Sibin@123'),
            'remember_token' => Str::random(10),
            'role' => 'employee',
            'company_id' => 1,
            'status' => 'active',

        ]);
    }
}