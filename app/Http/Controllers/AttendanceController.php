<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
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
//    public function ajax_search(Request $request){
//
//dd($request);
//        if($request->ajax()){
//
////            $search_by_text=$request->search_by_text;
//            dd($request->startDate);
////            $data=Treasuries::where('name','LIKE',"%{$search_by_text}%")->orderBy('id','DESC')->paginate(PAGINATION_COUNT);
////            return view('admin.treasuries.ajax_search',['data'=>$data]);
//        }
//    }
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

        return view('page.attendances.summary_report', compact('workedMinutesByUser', 'startDate', 'endDate'));
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
    

        // // Load the view and pass the data
        // $pdf = PDF::loadView('page.attendances.index', ['attendances' => $attendances]);
        // // return view("page.attendances.index", compact('attendances'));
        // // Download the PDF file
        // return $pdf->download('export.pdf');
        // view()->share('attendances',$attendances);
        // foreach($attendances as $attendance)
        // {
        //     print_r($attendance->start_time);
        //     echo'<br>';
        // }
        // die;
        $pdf = PDF::loadView('pdf_view', ['attendances'=>$attendances]);
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
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
