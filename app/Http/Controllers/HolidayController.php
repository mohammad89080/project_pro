<?php

namespace App\Http\Controllers;
use App\Models\Holiday;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HolidayController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:admin')->only(['method1', 'method2']); // Apply to method1 and method2
        $this->middleware('role:admin')->except(['index']); // Apply to other methods except method1 and method2
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $holidays=Holiday::all()->sortBy('holiday_date');
        return  view("page.holidays.index", compact('holidays'));
    }
    public function holidaysThisMonthDisplay()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $holidaysThisYear = Holiday::whereYear('holiday_date', $currentYear)->get();
        $holidays = Holiday::whereYear('holiday_date', $currentYear)
            ->whereMonth('holiday_date', $currentMonth)
            ->get();
        return view('page.holidays.index' ,compact('holidays'));
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
        try{

            $this->validate($request,[

                'holiday_date' =>['required','unique:Holidays,holiday_date,except,id']
            ]);

            Holiday::create(['holiday_date'=>$request->holiday_date]);
            toastr()->success('record added successfully');
            return redirect()->back();

        }catch(\Exception $e){
            toastr()->error($e->getMessage());
            return redirect()->back();
        }

    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $holiday = Holiday::whereId($id)->first();

        if ($holiday) {

            $holiday->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('holiday.index');
        }  else {
            // Handle the case when the user is not found
            toastr()->error(trans('messages.holidayNotFound'));
            return redirect()->route('holiday.index');
        }
    }
}
