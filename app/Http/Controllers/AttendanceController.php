<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    // app/Http/Controllers/AttendanceController.php

    public function toggleWork(Request $request, $user)
    {

        $attendance = Attendance::where('user_id', $user)
            ->where('attendance_date', now()->toDateString())
            ->first();

        if ($attendance) {
            if ($attendance->start_time && !$attendance->departure_time) {
                // If start time is set and end time is not set, set end time
                $attendance->departure_time = now()->toTimeString();

                // Calculate working hours
                $start = Carbon::parse($attendance->start_time);
                $end = Carbon::parse($attendance->departure_time);
                $workingHours = $end->diffInHours($start) + $end->diffInMinutes($start) / 60;
                $attendance->working_hours = $workingHours;
            } else {
                // If start time is not set or end time is set, set start time
                $attendance->start_time = now()->toTimeString();
                $attendance->departure_time = null;
                $attendance->working_hours = null;
            }

            $attendance->save();
        }

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
