<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\AttendanceController;
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

        $numberOfLeavesThisYearUser = $leavesThisYearUser->count();
        $numberOfLeavesGrantedUser  = $leavesGrantedUser->count();


        $report= new AttendanceController();
        $workedMinutesByUser  = $report->report2($startDate,$endDate);

//dd($workedMinutesByUser);
//die;


        return view('dashboard',compact('activeUserCount',
            'UserCount','numberOfHolidaysThisYear',
            'numberOfHolidaysThisMonth','numberOfLeavesThisYear',
            'numberOfLeavesGranted','numberOfLeavesThisYearUser',
            'numberOfLeavesGrantedUser','user','workedMinutesByUser'));
    }
}
