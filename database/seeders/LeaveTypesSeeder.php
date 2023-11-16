<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        LeaveType::create(['name' => 'emergency leave','maximum'=>50]);
        LeaveType::create(['name' => 'sick leave','maximum'=>50]);
    }
}
