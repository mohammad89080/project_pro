<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['index', 'getAttendance', 'report']); // Apply to method1 and method2
        // $this->middleware('role:admin')->except(['index_my']); // Apply to other methods except method1 and method2
    }

    public function startWork(Request $request)
    {

        $user = $request->user();


        $attendance = new Attendance([
            'attendance_date' => now()->toDateString(),
            'start_time' => now(),
            'user_id' => $user->id,
        ]);
        $workStartTime = config('app.work_start_time');
        $workStartTime ="19:30:00";

        $lateTime = $this->calculateLateTime($attendance->attendance_date, $attendance->start_time, $workStartTime);
        $attendance->late_time = $lateTime;

        $attendance->save();

        return redirect()->back()->with('success', 'Work started successfully.');
    }

    private function calculateLateTime($attendanceDate, $actualStartTime, $expectedStartTime)
    {

        $actualStartTime = Carbon::parse($actualStartTime)->format('H:i:s');

        $actualStart = Carbon::parse("$attendanceDate $actualStartTime");
        $expectedStart = Carbon::parse("$attendanceDate $expectedStartTime");


        $lateTime = $actualStart->diffInMinutes($expectedStart);

        return max(0, $lateTime);
    }

    public function finishWork(Request $request)
    {

        $user = $request->user();


        $attendance = Attendance::where('user_id', $user->id)
            ->whereNull('departure_time')
            ->latest()
            ->first();

        if ($attendance) {

            $attendance->departure_time = now();

            $start = Carbon::parse($attendance->start_time);
            $end = Carbon::parse($attendance->departure_time);
            $workingHours = $end->diffInHours($start) + $end->diffInMinutes($start) / 60;

            $attendance->working_time = $workingHours;

            $attendance->save();

            return redirect()->back()->with('success', 'Work ended successfully.');
        }

        return redirect()->back()->with('error', 'No active work session found.');
    }

  /**
     * Display a listing of the resource.
     */
    public function index ()
    {

        $users = User::all();
        $attendances = Attendance::with(['user'])->get();

        return view("page.attendances.index", compact('users','attendances'));

    }

    public function index_my ()
    {

        $attendances = Attendance::where('user_id', Auth::user()->id)->with(['user'])->get();
      
        return view("page.attendances.index", compact('attendances'));
    }


    public function getAttendance(Request $request)
    {

        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();


        if ($request->filled('startDate') && $request->filled('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
        }

        // Fetch grouped worked minutes by user for the selected date range
        $workedMinutesByUser = DB::table('attendances')
            ->select('users.name as userName', DB::raw('SUM(working_time) as totalWorkedMinutes'))
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name')
            ->get();

        return view('page.attendances.summary_report', compact('workedMinutesByUser', 'startDate', 'endDate'));
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
    public function report()
    {

        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();

        $workedMinutesByUser = $this->getWorkedMinutesByUsers($startDate, $endDate);

        return view('page.attendances.summary_report', compact('workedMinutesByUser', 'startDate', 'endDate'));
    }

    public function report_my(Request $request)
    {
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();

        if ($request->filled('startDate') && $request->filled('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
        }
        $user_id = Auth::user()->id;
        $workedMinutesByUser = $this->getWorkedMinutesByUser($user_id, $startDate, $endDate);

        return view('page.attendances.summary_report', compact('workedMinutesByUser', 'startDate', 'endDate'));return view('page.attendances.summary_report', compact('workedMinutesByUser', 'startDate', 'endDate'));
    }

    private function getWorkedMinutesByUser($user_id, $startDate, $endDate)
    {

        return DB::table('attendances')
            ->select(DB::raw('SUM(working_time) as totalWorkedMinutes'))
            ->where('user_id', $user_id)
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->get();
    }

    public function report2($startDate,$endDate)
    {

        $workedMinutesByUser = $this->getWorkedMinutesByUsers($startDate, $endDate);

        return $workedMinutesByUser;

    }


    private function getWorkedMinutesByUsers($startDate, $endDate)
    {
        // Fetch grouped worked minutes by user for the selected date range
        return DB::table('attendances')
            ->select('users.name as userName', DB::raw('SUM(working_time) as totalWorkedMinutes'))
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->groupBy('users.id', 'users.name')
            ->get();
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
