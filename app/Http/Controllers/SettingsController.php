<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings= Settings::latest()->first();
        return view("settings", compact('settings'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => ['required','string'],
                'footer' => ['required','string'],
                'start_work' => ['required',],
                'work_hours' => ['required','integer'],
                'logo' => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data['title'] = $request->title;
            $data['footer'] = $request->footer;
            $data['start_work'] = $request->start_work;
            $data['work_hours'] = $request->work_hours;
            
            if ($request->hasFile('logo')) {
                $imageName = time().'.'.$request->logo->extension();
                $request->logo->move(public_path('assets/images'), $imageName);
                $data['logo'] = $imageName;
            }
            elseif(Settings::latest()->first()){
                $data['logo'] = Settings::latest()->value('logo');
            }
            Settings::truncate();
            Settings::Create($data);

            toastr()->success(trans('messages.success'));
            return redirect()->route('settings.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);

        }
    }
}
