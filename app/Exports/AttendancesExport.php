<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class AttendancesExport implements FromCollection, WithHeadings
{
    protected $user_id;

    // Constructor to accept the id parameter
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('attendances')
        ->select('users.name as username', 'attendances.attendance_date', 'attendances.start_time', 'attendances.departure_time', 'attendances.working_time', 'attendances.status')
        ->join('users', 'attendances.user_id', '=', 'users.id')
        ->where('attendances.user_id', $this->user_id)
        ->get();
    }

    public function headings(): array
    {
        return [
            'username',
            'attendance_date',
            'start_time',
            'departure_time',
            'working_time',
            'status',
            
        ];
    }
}
