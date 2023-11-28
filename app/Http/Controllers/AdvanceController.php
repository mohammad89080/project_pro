<?php

namespace App\Http\Controllers;

use App\Models\Advance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class AdvanceController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin')->only([ 'destroy','update']); // Apply to method1 and method2
        // $this->middleware('role:admin')->except(['store']); // Apply to other methods except method1 and method2
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user_id=Auth::user()->id;

        $roles=Auth::user()->getRoleNames()->toArray();
        if(in_array( 'admin', $roles ))
        {
            $advances = Advance::with('user')->get();

            $users = User::all();

            return view('page.advances.index', compact('advances', 'users'));
        }
        else
        {
            $advances = Advance::where('user_id',$user_id)->with('user')->get();

            return view('page.advances.index_user', compact('advances'));
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.advances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'amount' => 'required|numeric',
            
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $user_id=Auth::user()->id;

            $roles=Auth::user()->getRoleNames()->toArray();
            if(in_array( 'admin', $roles ))
            {
                $data['user_id'] = $request->user_id;
                $data['status'] = 'Granted';
            }
            else
            {
                $data['user_id'] = $user_id;
            }
            
            $data['amount'] = $request->amount;
            if(isset($request->notes)) $data['notes'] = $request->notes;

            Advance::create($data);

            $user = User::role('admin')->get();
            Notification::send($user, new \App\Notifications\Leavenotifications($user_id));

            toastr()->success(trans('messages.success'));
            return redirect()->route('advance.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Advance $advance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advance $advance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), 
                [
                    'amount' => ['required','numeric'],
                    'status' => ['required','string', Rule::in(['Granted','Pending','Rejected'])],
                ]
            );

            $data['amount'] = $request->amount;
            $data['status'] = $request->status;
            $advance = Advance::find($id);
            $advance->update($data);

            toastr()->success('advance updated successfully');
            return redirect()->route('advance.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $advance = Advance::whereId($id)->first();

        if ($advance) {

            $advance->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('advance.index');
        }  else {
            // Handle the case when the user is not found
            toastr()->error(trans('messages.advanceTypeNotFound'));
            return redirect()->route('advance.index');
        }
    }
}
