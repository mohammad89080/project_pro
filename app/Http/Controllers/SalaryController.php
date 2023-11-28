<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $data = Salary::with(['user'])->orderBy('id', 'desc')->get();
        return view('page.salaries.index',compact('data','users'));
    }
    public function calculateMonthlyDues($user_id,$monthlySalary,$requiredWorkingHours)
    {

        $workedTime = DB::table('attendances')
            ->select(DB::raw('SUM(working_time) as totalWorkedSeconds'))
            ->where('user_id', $user_id)
            ->whereYear('attendance_date', now()->year)
            ->whereMonth('attendance_date', now()->month)
            ->first();
//        $monthlySalary = 1000;
//        $requiredWorkingHours = 160;
        $totalWorkedHours = $workedTime->totalWorkedSeconds / 3600;

        $hourlyRate = $monthlySalary / $requiredWorkingHours;

        $totalDues = $hourlyRate * $totalWorkedHours;

        return $totalDues;
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
        try {
            $validator = Validator::make($request->all(), [
                'salary' => ['required'],
                'user_id' => ['required']

//                'role' => ['required', 'string', Rule::in(['admin','user'])],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $salaryFloat = $request->salary;
            $data['salary_amount'] =$salaryFloat;
            $data['user_id'] = $request->user_id;

            $user=Salary::create($data);


            toastr()->success(trans('messages.success'));
            return redirect()->route('salary.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'salary' => ['required'],
                'user_id' => ['required']


            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $salary = Salary::whereId($id)->first();
            if ($salary) {
//                dd($request);
                $salaryFloat = $request->salary;
                $data['salary_amount'] = $salaryFloat;
                $data['user_id'] = $request->user_id;

                $salary->update($data);
                toastr()->success(trans('messages.Update'));
                return redirect()->route('salary.index');
            }
            return redirect()->route('salary.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        //
    }
}
