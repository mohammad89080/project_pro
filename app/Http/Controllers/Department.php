<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use \App\Models;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Department extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $dpartemnts = Models\Department::all();
//        dd($dpartemnts);

       return view('page.departments.index',compact('dpartemnts'));
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

//                'role' => ['required', 'string', Rule::in(['admin','user'])],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['name'] = $request->name;


            $department= Models\Department::create($data);
            toastr()->success(trans('messages.success'));
            return redirect()->route('department.index');
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
        $department = Models\Department::whereId($id)->first();

        if ($department) {

            $department->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('department.index');
        }  else {
            // Handle the case when the user is not found
            toastr()->error(trans('messages.UserNotFound'));
            return redirect()->route('department.index');
        }
    }
}
