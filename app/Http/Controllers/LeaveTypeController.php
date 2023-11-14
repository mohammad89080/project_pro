<?php

namespace App\Http\Controllers;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leave_types = LeaveType::all();
        return view("page.leave_types.index", compact('leave_types'));
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
                'name' => ['required', 'string', 'max:255'],
                'maximum' => ['required', 'integer', 'min:1', 'max:100'],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['name'] = $request->name;
            $data['maximum'] = $request->maximum;
            LeaveType::create($data);
            toastr()->success(trans('messages.success'));
            return redirect()->route('leave-types');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
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
        $leave_type = LeaveType::whereId($id)->first();

        if ($leave_type) {

            $leave_type->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('leave-types.index');
        }  else {
            // Handle the case when the user is not found
            toastr()->error(trans('messages.leaveTypeNotFound'));
            return redirect()->route('leave-types.index');
        }
    }
}
