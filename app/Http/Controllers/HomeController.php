<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AttendanceController;

use App\Models\Holiday;
use App\Models\Leave;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

        $numberOfHolidaysThisYear = $holidaysThisYear->count();
        $numberOfHolidaysThisMonth = $holidaysThisMonth->count();

        $numberOfLeavesThisYear = $leavesThisYear->count();
        $numberOfLeavesGranted  = $leavesGranted->count();


        $numberOfLeavesThisYearUser = $leavesThisYearUser->count();
        $numberOfLeavesGrantedUser  = $leavesGrantedUser->count();

        $AttendancObject= new AttendanceController();
        $workedMinutesByUser  = $AttendancObject->report2($startDate,$endDate);
        $attendanceSummary = $AttendancObject->getAttendanceSummary($currentDate);
        $workedMinutesByUserForHome = $AttendancObject->getWorkedMinutesByUserForLast30Days();
        $getWorkedMinutesByUserForWorkingTodays = $AttendancObject->getWorkedMinutesByUserForWorkingTodays();
//        print_r($getWorkedMinutesByUserForWorkingTodays);
//die;
//

        $activeUsersCount = User::where('status', '1')->count();
        $inactiveUsersCount = User::where('status', '0')->count();
//        die(print_r($activeUsersCount));
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['المستخدمين النشطين', 'المستخدمين غير النشطين'])
            ->datasets([
                [
                    'label' => 'المستخدمين النشطين',

                    'backgroundColor' => ['rgba(0, 255, 0, 0.5)'], // Green
                    'data' => [$activeUsersCount,$inactiveUsersCount],
                ],
//                [
//                    'label' => 'المستخدمين غير النشطين',
//                    'backgroundColor' => ['rgba(255, 0, 0, 0.5)'], // Red
//                    'data' => [$inactiveUsersCount],
//                ],
            ])
            ->optionsRaw([
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'fontColor' => 'black',
                        'fontStyle' =>'bold',
                        'fontFamily' =>'Markazi Text',
                        'fontSize' =>20,
                    ]

                ]

            ]);
        $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Label x', 'Label y'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [$activeUsersCount,$inactiveUsersCount]
                ]
            ])
            ->optionsRaw([
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'fontColor' => 'black',
                        'fontStyle' =>'bold',
                        'fontSize' =>16,
                    ]

                ]

            ]);
        $user_id = Auth::user()->id;
        // $monthlyWorkedMinutes = $this->getMonthlyWorkedMinutesByUser($user_id);
        
        $dateData = $this->getDateNamesOneMonthAgoUntilToday();
        $chartjs3 = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($dateData[0])
            ->datasets([
                [
                    "label" => "دقائق العمل الشهرية",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $dateData[1],
                ],
            ])
            ->optionsRaw([
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'fontColor' => 'black',
                        'fontStyle' =>'bold',
                        'fontSize' =>16,
                    ]

                ]

            ]);




//dd($monthlyWorkedMinutes);

        return view('dashboard',compact('activeUserCount',
            'UserCount','numberOfHolidaysThisYear',
            'numberOfHolidaysThisMonth','numberOfLeavesThisYear','chartjs','chartjs2','chartjs3',

            'numberOfLeavesGranted','user','workedMinutesByUser','attendanceSummary'
            ,'numberOfLeavesThisYearUser','numberOfLeavesGrantedUser'
            ,'workedMinutesByUserForHome','getWorkedMinutesByUserForWorkingTodays'));




    }
    // private function getMonthlyWorkedMinutesByUser($user_id)
    // {
    //     // Fetch monthly worked minutes by user for the current year
    //     return DB::table('attendances')
    //         ->select(
    //             DB::raw('MONTH(attendance_date) as month'),
    //             DB::raw('SUM(working_time) as totalWorkedMinutes')
    //         )
    //         ->where('user_id', $user_id)
    //         ->whereYear('attendance_date', Carbon::now()->year)
    //         ->groupBy(DB::raw('MONTH(attendance_date)'))
    //         ->get()
    //         ->pluck('totalWorkedMinutes', 'month');
    // }

function getDateNamesOneMonthAgoUntilToday()
{
    $startDate = Carbon::now()->subMonth(); // One month ago
    $endDate = Carbon::now(); // Today

    $dateNames = [];
    $data = [];
    while ($startDate->lte($endDate)) {

        // echo $startDate->format('Y-m-d');
        $data[]=Attendance::where('attendance_date', $startDate->format('Y-m-d'))
        ->where('user_id', Auth::user()->id)
        ->sum('working_time');
        $dateNames[] = $startDate->format('d M');
        $startDate->addDay();
    }

    return [$dateNames, $data];
}


}
