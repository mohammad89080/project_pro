<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\returnArgument;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {

        $users = User::with(['department'])->orderBy('id', 'desc')->get();

        return view("page.users.index", compact('users'));
    }


    public function create()
    {
        $departments = Department::all();

        return view("page.users.create", compact('departments'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'department_id' => ['required'],
            'role' => ['required', 'string', Rule::in(['admin','user'])],
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'department_id' => ['required'],
                'role' => ['required', 'string', Rule::in(['admin','user'])],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = Hash::make($request->password);
            $data['status'] = $request->status;
            $data['department_id'] = $request->department_id;

            $user=User::create($data);
            $user->assignRole($request->role);
            toastr()->success(trans('messages.success'));
            return redirect()->route('user.create');
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
    public function edit($id)
    {
        $user = User::whereId($id)->first();
        if ($user) {
            $departments = Department::all();
            return view('page.users.edit', compact('user', 'departments'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
//                'password' => ['required', 'string', 'min:8'],
                'department_id' => ['required']
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $user = User::whereId($id)->first();
            if ($user) {
//                dd($request);
                $data['name'] = $request->name;
                $data['email'] = $request->email;
                if ($request->password) {

                    $data['password'] = Hash::make($request->password);
                }
                $data['status'] = $request->status;
                $data['department_id'] = $request->department_id;

                $user->update($data);
                toastr()->success(trans('messages.Update'));
                return redirect()->route('user.index');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {

        $user = User::whereId($id)->first();

        if ($user) {

            $user->delete();
            toastr()->error(trans('messages.Delete'));
            return redirect()->route('user.index');
        }  else {
            // Handle the case when the user is not found
            toastr()->error(trans('messages.UserNotFound'));
            return redirect()->route('user.index');
        }
    }

}
