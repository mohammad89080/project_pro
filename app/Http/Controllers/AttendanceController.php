<?php

namespace App\Http\Controllers;
use Illuminate\Console\Scheduling\Schedule;

use App\Models\Attendance;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\AttendancesExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;



class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['index', 'getAttendance', 'report']); // Apply to method1 and method2
        // $this->middleware('role:admin')->except(['index_my']); // Apply to other methods except method1 and method2
    }

//    public function startWork(Request $request)
//    {
//
//        $user = $request->user();
//
//
//        $attendance = new Attendance([
//            'attendance_date' => now()->toDateString(),
//            'start_time' => now(),
//            'user_id' => $user->id,
//        ]);
//        $workStartTime = config('app.work_start_time');
//        $workStartTime ="19:30:00";
//
//        $lateTime = $this->calculateLateTime($attendance->attendance_date, $attendance->start_time, $workStartTime);
//        $attendance->late_time = $lateTime;
//
//        $attendance->save();
//
//        return redirect()->back()->with('success', 'Work started successfully.');
//    }
//
//    private function calculateLateTime($actualStartTime, $expectedStartTime)
//    {
//        $actualStart = Carbon::createFromTimestamp($actualStartTime);
//        $expectedStart = Carbon::createFromTimestamp($expectedStartTime);
//
//        $lateTime = $actualStart->diffInMinutes($expectedStart);
//
//        return max(0, $lateTime);
//    }
//    private function calculateLateTime($actualStartTime, $workStartTime)
//    {
//        // Convert actual start time and work start time to Carbon instances
//        $actualStart = Carbon::createFromTimestamp($actualStartTime);
//
//        $expectedStart = Carbon::parse($actualStart->toDateString() . ' ' . $workStartTime);
//
//        // Calculate the delay in seconds
//        $delayInSeconds = $actualStart->diffInSeconds($expectedStart);
//
//        // Return the delay in seconds, ensuring it's not negative
//        return max(0, $delayInSeconds);
//    }
    private function calculateLateTime($actualStartTime, $workStartTime)
    {
        // Convert actual start time and work start time to Carbon instances
        $actualStart = Carbon::parse($actualStartTime);

        // Parse the work start time and set it to the same date as actual start time
        $expectedStart = Carbon::parse($workStartTime)->setDate(
            $actualStart->year,
            $actualStart->month,
            $actualStart->day
        );

        // Check if the actual start time is later than the expected start time
        // If it's earlier, there is no delay
        if ($actualStart->lte($expectedStart)) {
            return 0;
        }

        // Calculate the delay in seconds
        $delayInSeconds = $actualStart->diffInSeconds($expectedStart);

        // Return the delay in seconds
        return $delayInSeconds;
    }

//
//    public function finishWork(Request $request)
//    {
//
//        $user = $request->user();
//
//
//        $attendance = Attendance::where('user_id', $user->id)
//            ->whereNull('departure_time')
//            ->latest()
//            ->first();
//
//        if ($attendance) {
//
//            $attendance->departure_time = now();
//
//            $start = Carbon::parse($attendance->start_time);
//            $end = Carbon::parse($attendance->departure_time);
//            $workingHours = $end->diffInHours($start) + $end->diffInMinutes($start) / 60;
//
//            $attendance->working_time = $workingHours;
//
//            $attendance->save();
//
//            return redirect()->back()->with('success', 'Work ended successfully.');
//        }
//
//        return redirect()->back()->with('error', 'No active work session found.');
//    }
    public function startWork(Request $request)
    {
        $user = $request->user();

        $attendance = new Attendance([
            'attendance_date' => now()->toDateString(),
            'start_time' => now(),
            'user_id' => $user->id,
        ]);
        $settings  = Settings::first();

//        $workStartTime = config('app.work_start_time');
        $workStartTime = $settings->start_work;


//        $lateTime = $this->calculateLateTime($attendance->attendance_date, $attendance->start_time, $workStartTime);
        $lateTime = $this->calculateLateTime($attendance->start_time, $workStartTime);

        $attendance->late_time = $lateTime;

        $attendance->save();

        return redirect()->back()->with('success', 'Work started successfully.');
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
            $workingTimeInSeconds = $end->diffInSeconds($start);

            $attendance->working_time = $workingTimeInSeconds;

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


//        $workedMinutesByUser1 = $workedMinutesByUser;


        return view('page.attendances.summary_report', compact('workedMinutesByUser', 'startDate', 'endDate'));
    }

    public function getWorkedMinutesByUserForLast30Days()
    {
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();


        $user_id = Auth::user()->id;
        $workedMinutesByUser = $this->getWorkedTimeByUser($user_id, $startDate, $endDate);

        return $workedMinutesByUser;
    }
    public function getWorkedMinutesByUserForWorkingTodays()
    {

        $currentDate = Carbon::now()->toDateString();
        $user_id = Auth::user()->id;

        $workedMinutesForToday = $this->getWorkedTimeByUser($user_id, $currentDate, $currentDate);

        return $workedMinutesForToday;

    }



    private function getWorkedMinutesByUser($user_id, $startDate, $endDate)
    {

        return DB::table('attendances')
            ->select(DB::raw('SUM(working_time) as totalWorkedMinutes'))
            ->where('user_id', $user_id)
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->get();
    }
    private function getWorkedTimeByUser($user_id, $startDate, $endDate)
    {
        $workedTime = DB::table('attendances')
            ->select(DB::raw('SUM(working_time) as totalWorkedSeconds'))
            ->where('user_id', $user_id)
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->first();

        $totalWorkedSeconds = $workedTime->totalWorkedSeconds ?? 0;

        $hours = floor($totalWorkedSeconds / 3600);
        $minutes = floor(($totalWorkedSeconds % 3600) / 60);
        $seconds = $totalWorkedSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
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


    public function getAttendanceSummary($selectedDate)
    {

        $totalUsers = User::count();

        // Get the number of users who have started work on the selected date but haven't finished it
        $activeUsersCount = User::whereHas('attendances', function ($query) use ($selectedDate) {
            $query->where('attendance_date', $selectedDate)
                ->whereNotNull('start_time')
                ->whereNull('departure_time');
        })->count();

        // Get the number of users who were absent on the selected date
        $absentUsersCount = $totalUsers - $activeUsersCount;

        return [
            'totalUsers' => $totalUsers,
            'absentUsersCount' => $absentUsersCount,
            'activeUsersCount' => $activeUsersCount,
        ];

    }


    public function export($user_id)
    {
        return Excel::download(new AttendancesExport($user_id), 'user_' . $user_id . '_attendances.xlsx');
    }

    public function exportToPDF($user_id)
    {
        // Fetch your data
        $attendances = Attendance::where('user_id', $user_id)->get();
        // $attendances = Attendance::All();
        // $attendances = Attendance::where('user_id', Auth::user()->id)->with(['user'])->get();



        view()->share('attendances',$attendances);

        $pdf = PDF::loadView('pdf_view', ['attendances'=>$attendances])->setOptions(['defaultFont' => 'sans-serif']);;
        // download PDF file with download method
        return $pdf->download($attendances[0]->user->name.'_file_report.pdf');
    }

    
//
//    public function getAttendanceSummary($selectedDate)
//    {
//        // Get the total number of users
//        $totalUsers = User::count();
//
//        // Get the number of users who were absent on the selected date
//        $absentUsersCount = User::whereDoesntHave('attendances', function ($query) use ($selectedDate) {
//            $query->where('attendance_date', $selectedDate);
//        })->count();
//
//        // Get the number of users who were present (active) on the selected date
//        $activeUsersCount = $totalUsers - $absentUsersCount;
//
//        return [
//            'totalUsers' => $totalUsers,
//            'absentUsersCount' => $absentUsersCount,
//            'activeUsersCount' => $activeUsersCount,
//        ];
//    }
}
