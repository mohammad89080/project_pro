<?php

namespace App\Http\Controllers;
use App\Models\LeaveType;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only(['index', 'destroy','update_status']); // Apply to method1 and method2
        // $this->middleware('role:admin')->except(['store']); // Apply to other methods except method1 and method2
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaves = Leave::all(); 
        return view("page.leaves.index", compact('leaves'));
    }
    public function index_my()
    {
        $leaves = Leave::where('user_id', Auth::user()->id)->get();
        return view("page.leaves.index", compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leave_types = LeaveType::all();
        return view("page.leaves.create", compact('leave_types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'date' => ['required',],
                'leave_type' => ['required', 'integer', Rule::exists('leave_types', 'id'),],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['date'] = $request->date;
            $data['leave_id'] = $request->leave_type;
            $data['user_id'] = Auth::user()->id;
            $data['description'] = $request->description;

            Leave::create($data);
            toastr()->success(trans('messages.success'));
            return redirect()->route('leave');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {

    }
    public function update_status( $id, $status)
    {
        try {
            $validator = Validator::make(
                compact('id', 'status'),
                [
                    'id' => ['required','numeric',Rule::exists('leaves', 'id')],
                    'status' => ['required','string', Rule::in(['Granted','Pending','Rejected'])],
                ]
            );
            $leave = Leave::find($id);

            $data['status'] = $status;
            $leave->update($data);
            
            toastr()->success('status updated successfully');
            return redirect()->route('leave');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $leave = Leave::whereId($id)->first();

        if ($leave) {

            $leave->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('leave.index');
        }  else {
            // Handle the case when the user is not found
            toastr()->error(trans('messages.leaveTypeNotFound'));
            return redirect()->route('leave.index');
        }
    }
}
