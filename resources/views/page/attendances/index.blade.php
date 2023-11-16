@extends('layouts.master')
@section('css')

    @section('title')
        {{ trans('main_trans.Users') }}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        {{ trans('main_trans.Users') }}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row">
    <div class="col-xl-12 mb-30">
        <div class="card">
            <div class="card-body" style="padding: 1rem 1.81rem;">

                <form action="{{route('get-attendance')}}" method="post">
                    @csrf
                    <div class="form-row align-items-center content-center">
                        <div class="col-sm-3 my-1 form-group">

                            <select name="userSelect"  style="padding-bottom: 11px;"  class="form-control" required="">
                                <option value="">--- Please Select User ---</option>
                                @foreach($users as $user )
                                <option value="{{$user->id}}">  {{$user->name}}   </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-sm-3 my-1 flex">
                            <button id="reportButton"  class="btn btn-success ml-2 btn-fw" type="submit">

                               Report
                            </button>
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
                    <div class="table-responsive">
{{--                                                table-striped--}}
                        <table id="datatable" class="table  table-bordered p-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>

                                <th>Date</th>
                                <th>In Time	</th>
                                <th>Out Time</th>
                                <th>Worked</th>
                                <th>Time Late</th>


                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach($attendances as $attendance)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$attendance->user->name}}</td>
                                    <td>{{$attendance->attendance_date}}</td>

                                    <td>{{$attendance->start_time}}</td>
                                    <td>{{$attendance->departure_time}}</td>
                                    <td>{{$attendance->working_time}}</td>
                                    <td>{{$attendance->late_time}}</td>


{{--                                    <td style="color: {{ $user->status ? 'green' : 'red' }}">--}}
{{--                                        {{ $user->status ? 'Active' : 'Inactive' }}--}}
{{--                                    </td>--}}

                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>

                                <th>Date</th>
                                <th>In Time	</th>
                                <th>Out Time</th>
                                <th>Worked</th>
                                <th>Time Late</th>

                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>

</div>

@endsection
