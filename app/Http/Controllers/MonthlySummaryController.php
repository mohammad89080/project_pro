<?php

namespace App\Http\Controllers;

use App\Models\MonthlySummary;
use App\Models\Advance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;
class MonthlySummaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $monthly_summary = MonthlySummary::all()->sortBy('year')->sortBy('month');
        $advance=[];
        foreach ($monthly_summary as $summary) {
            $advance[$summary->user_id.$summary->month] = DB::table('advances')
            ->where('user_id', $summary->user_id)
            ->where('status', 'Granted')
            ->where(DB::raw('MONTH(created_at)'), $summary->month)
            ->sum('amount');
        }

        return view("page.monthly_summary.index", compact('monthly_summary','advance'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MonthlySummary $monthlySummary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MonthlySummary $monthlySummary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MonthlySummary $monthlySummary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MonthlySummary $monthlySummary)
    {
        //
    }
}
