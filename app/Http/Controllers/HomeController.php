<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
    public function index()
    {
        $activeUserCount = User::where('status', '1')->count();
        $UserCount = User::count();
        $holidays = Holiday::all();

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $holidaysThisYear = Holiday::whereYear('holiday_date', $currentYear)->get();
        $holidaysThisMonth = Holiday::whereYear('holiday_date', $currentYear)
            ->whereMonth('holiday_date', $currentMonth)
            ->get();
//        dd($holidaysThisMonth);
        $numberOfHolidaysThisYear = $holidaysThisYear->count();
        $numberOfHolidaysThisMonth = $holidaysThisMonth->count();



        return view('dashboard',compact('activeUserCount','UserCount','numberOfHolidaysThisYear','numberOfHolidaysThisMonth'));
    }
}
