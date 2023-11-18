@extends('layouts.master')
@section('css')

    @section('title')
        {{ trans('main_trans.SummaryReport') }}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        {{ trans('main_trans.SummaryReport') }}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card">
                <div class="card-body" style="padding: 1rem 1.81rem;">
<<<<<<< HEAD
        @role('admin')
=======



        @role('admin')

>>>>>>> 8fe994b62a67b7fd28733bb3628de18ec73b2e32
        <form action="{{ route('get-attendance') }}" method="post">

        @else
        <form action="{{ route('attendance.mysumary') }}" method="get" >
        @endrole

            @csrf

            <div class="form-row align-items-center mb-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <input required name="startDate" class="form-control" placeholder="{{ trans('main_trans.StartDate') }}" autocomplete="off"  id="datepicker-action"  data-date-format="yyyy-mm-dd">
                        <span class="input-group-text border-0" style="background-color: #F6F7F8;"><i class="fa fa-calendar"></i> </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input required name="endDate" class="form-control" placeholder="{{ trans('main_trans.EndDate') }}" autocomplete="off"  id="datepicker-action2"  data-date-format="yyyy-mm-dd">
                        <span class="input-group-text border-0" style="background-color: #F6F7F8;"><i class="fa fa-calendar"></i></span>
                    </div>

<<<<<<< HEAD
=======

>>>>>>> 8fe994b62a67b7fd28733bb3628de18ec73b2e32
                </div>
                <div class="col-md-4">
                    <button style="width: 44%;" type="submit" class="btn btn-primary btn-lg ">Filter</button>
                </div>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
        <p>{{ trans('main_trans.periodFilter') }} {{ $startDate }}  {{ $endDate }}</p>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('forms.Name') }}</th>
                    <th>{{ trans('main_trans.WordHour') }}</th>
                </tr>
                </thead>
                <tbody>
          @foreach($workedMinutesByUser as $index => $result)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @role('admin')
                                {{ $result->userName }}
                                @else
                                {{ auth()->user()->name }}
                                @endrole
                            </td>
                            @php
                                $totalWorkedSeconds = $result->totalWorkedMinutes ?? 0;

                            $hours = floor($totalWorkedSeconds / 3600);
                            $minutes = floor(($totalWorkedSeconds % 3600) / 60);
                            $seconds = $totalWorkedSeconds % 60;

                                    $time_work = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                            @endphp
                            <td>{{ $time_work }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
            </div>
        </div>
    </div>
    </div>
@endsection
