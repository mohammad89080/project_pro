@extends('layouts.master')
@section('css')

    @section('title')
        {{-- {{ trans('main_trans.Users') }} --}}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        {{-- {{ trans('main_trans.Users') }} --}}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="table-responsive">
{{--                        table-striped--}}
                        <table id="datatable" class="table  table-bordered p-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>السنة</th>
                                <th>الشهر</th>
                                <th> {{ trans('forms.Name') }}</th>
                                <th> {{ trans('forms.Email') }}</th>
                                <th>{{ trans('forms.Department') }}</th>
                                <th>عدد ساعات عمل هذا الشهر</th>
                                <th>مستحقات هذا الشهر</th>
                                <th>مجموع السلف هذا الشهر</th>
                                <th>المستحقات النهائية</th>

                            </tr>
                            </thead>
                            <tbody>
                            @php
                            $i=0;
                            @endphp
                            @foreach($monthly_summary as $summary)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$summary->year}}</td>
                                    <td>{{$summary->month}}</td>
                                    <td>{{$summary->user->name}}</td>
                                    <td>{{$summary->user->email}}</td>
                                    <td>{{$summary->user->department->name}}</td>
                                    <td>{{$summary->user->total_worked_hours}}</td>
                                    <td>{{$summary->total_salary_due}}</td>
                                    <td>{{$advance[$summary->user_id.$summary->month]}}</td>
                                    <td>{{$summary->total_salary_due - $advance[$summary->user_id.$summary->month]}}</td>

                                    
                                </tr>
                            @endforeach


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>السنة</th>
                                    <th>الشهر</th>
                                    <th> {{ trans('forms.Name') }}</th>
                                    <th> {{ trans('forms.Email') }}</th>
                                    <th>{{ trans('forms.Department') }}</th>
                                    <th>عدد ساعات عمل هذا الشهر</th>
                                    <th>مستحقات هذا الشهر</th>
                                    <th>مجموع السلف هذا الشهر</th>
                                    <th>المستحقات النهائية</th>
    
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')

@endsection
