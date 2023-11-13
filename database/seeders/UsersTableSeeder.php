<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'mohammad bakkar',
            'email' => 'mohammad.bakkar89080@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'status' => 1, // or 0 based on your requirement
            'department_id' => 1, // replace with the actual department_id
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
