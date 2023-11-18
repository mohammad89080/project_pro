<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AttendanceController;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();
        // Set default values for $startDate and $endDate to cover the current month
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();

        // Update values based on user input
        if ($request->filled('startDate') && $request->filled('endDate')) {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
        }
        $activeUserCount = User::where('status', '1')->count();
        $user = User::whereId(auth()->id())->first();
        $UserCount = User::count();
        $holidays = Holiday::all();

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $holidaysThisYear = Holiday::whereYear('holiday_date', $currentYear)->get();
        $holidaysThisMonth = Holiday::whereYear('holiday_date', $currentYear)
            ->whereMonth('holiday_date', $currentMonth)
            ->get();

        $leavesThisYear = Leave::whereYear('date', $currentYear)->get();
        $leavesGranted = Leave::where('status','Granted')->get();


        $leavesThisYearUser = Leave::where('user_id',Auth::user()->id)->whereYear('date', $currentYear)->get();
        $leavesGrantedUser = Leave::where('user_id',Auth::user()->id)->where('status','Granted')->get();
//        dd($holidaysThisMonth);
        $numberOfHolidaysThisYear = $holidaysThisYear->count();
        $numberOfHolidaysThisMonth = $holidaysThisMonth->count();

        $numberOfLeavesThisYear = $leavesThisYear->count();
        $numberOfLeavesGranted  = $leavesGranted->count();

        $AttendancObject= new AttendanceController();
        $workedMinutesByUser  = $AttendancObject->report2($startDate,$endDate);

        $attendanceSummary = $AttendancObject->getAttendanceSummary($currentDate);
//        dd($AttendanceSummary);

        $numberOfLeavesThisYearUser = $leavesThisYearUser->count();
        $numberOfLeavesGrantedUser  = $leavesGrantedUser->count();


        $report= new AttendanceController();
        $workedMinutesByUser  = $report->report2($startDate,$endDate);


//dd($workedMinutesByUser);
//die;

$startDate = Carbon::now()->subMonth(); // One month ago
    $endDate = Carbon::now(); // Today

    $dateNames = [];

    while ($startDate->lte($endDate)) {
        $dateNames[] = $startDate->format('d M');
        $startDate->addDay();
    }


// $chartjs = app()->chartjs
//         ->name('lineChartTest')
//         ->type('line')
//         ->size(['width' => 400, 'height' => 200])
//         ->labels($dateNames)
//         ->datasets([
//             [
//                 "label" => "My First dataset",
//                 'backgroundColor' => "rgba(38, 185, 154, 0.31)",
//                 'borderColor' => "rgba(38, 185, 154, 0.7)",
//                 "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
//                 "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
//                 "pointHoverBackgroundColor" => "#fff",
//                 "pointHoverBorderColor" => "rgba(220,220,220,1)",
//                 'data' => [65, 59, 80, 81, 56, 55, 40],
//             ],
//             [
//                 "label" => "My Second dataset",
//                 'backgroundColor' => "rgba(38, 185, 154, 0.31)",
//                 'borderColor' => "rgba(38, 185, 154, 0.7)",
//                 "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
//                 "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
//                 "pointHoverBackgroundColor" => "#fff",
//                 "pointHoverBorderColor" => "rgba(220,220,220,1)",
//                 'data' => [12, 33, 44, 44, 55, 23, 40],
//             ]
//         ])
//         ->options([]);

$activeUsersCount = User::where('status', 'active')->count();
$inactiveUsersCount = User::where('status', 'inactive')->count();

$chartjs = app()->chartjs
    ->name('barChartTest')
    ->type('bar')
    ->size(['width' => 400, 'height' => 200])
    ->labels(['Active Users', 'Inactive Users'])
    ->datasets([
        [
            'label' => 'Active Users',
            'backgroundColor' => ['rgba(0, 255, 0, 0.2)'],
            'data' => [$activeUsersCount],
        ],
        [
            'label' => 'Inactive Users',
            'backgroundColor' => ['rgba(255, 0, 0, 0.2)'],
            'data' => [$inactiveUsersCount],
        ],
    ])
    ->options([]);
        return view('dashboard',compact('activeUserCount',
            'UserCount','numberOfHolidaysThisYear',
            'numberOfHolidaysThisMonth','numberOfLeavesThisYear',

            'numberOfLeavesGranted','user','workedMinutesByUser','attendanceSummary','chartjs'));




    }
}
