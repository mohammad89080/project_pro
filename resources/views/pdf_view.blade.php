@extends('layouts.master')
@section('css')

    @section('title')
        {{ trans('main_trans.ReportAll') }}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        {{ trans('main_trans.ReportAll') }}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')


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
            $i = 0;
            $lastDate = null;
        @endphp

        @foreach($attendances as $attendance)
            @php
                $i++;

            @endphp
            <tr class="filter-data">
                <td>{{$i}}</td>
                {{-- <td>{{$attendance->user->name}}</td> --}}
                @if ($attendance->attendance_date != $lastDate)

                    <td>{{ $attendance->attendance_date }}</td>
                @else

                    <td></td>
                @endif
                {{--                                    <td>{{$attendance->attendance_date}}</td>--}}

                <td>{{$attendance->start_time}}</td>
                <td>{{$attendance->departure_time}}</td>
                <td>{{$attendance->working_time}}</td>
                <td>{{$attendance->late_time}}</td>

                @php
                    $lastDate = $attendance->attendance_date;
                @endphp
                {{--                                    <td style="color: {{ $user->status ? 'green' : 'red' }}">--}}
                {{--                                        {{ $user->status ? 'Active' : 'Inactive' }}--}}
                {{--                                    </td>--}}
            </tr>
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

@endsection
