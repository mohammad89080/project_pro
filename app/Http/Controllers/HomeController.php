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

        $AttendancObject= new AttendanceController();
        $workedMinutesByUser  = $AttendancObject->report2($startDate,$endDate);

        $attendanceSummary = $AttendancObject->getAttendanceSummary($currentDate);


        $numberOfLeavesThisYearUser = $leavesThisYearUser->count();
        $numberOfLeavesGrantedUser  = $leavesGrantedUser->count();
        $workedMinutesByUserForHome = $AttendancObject->getWorkedMinutesByUserForLast30Days();
        $getWorkedMinutesByUserForWorkingTodays = $AttendancObject->getWorkedMinutesByUserForWorkingTodays();




        return view('dashboard',compact('activeUserCount',
            'UserCount','numberOfHolidaysThisYear',
            'numberOfHolidaysThisMonth','numberOfLeavesThisYear',

            'numberOfLeavesGranted','user','workedMinutesByUser','attendanceSummary'
            ,'numberOfLeavesThisYearUser','numberOfLeavesGrantedUser'
            ,'workedMinutesByUserForHome','getWorkedMinutesByUserForWorkingTodays'));




    }
}
