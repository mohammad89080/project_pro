

@extends('layouts.master')
@section('css')
@section('title')

    {{trans('main_trans.LeaveTypes')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
{{trans('main_trans.LeaveTypes')}}
<!-- breadcrumb -->
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                    <h5>{{trans('main_trans.Leave_application')}}</h5> <br>

                    <form class="forms-sample" action="{{ route('leave.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="nameInput">
                                {{ trans('forms.Date') }}
                            </label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input required class="form-control" placeholder="Date" autocomplete="off"  id="datepicker-action" name="date" data-date-format="yyyy-mm-dd">
                                    <span class="input-group-text border-0" style="background-color: #F6F7F8;"><i class="fa fa-calendar"></i></span>
                                </div>
                                @error('date')<span class="text-danger">{{ $message }}</span>@enderror

                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="rrr">
                                Leaves type
                            </label>
                            <div class="col-sm-5">
                                <select style="height: 93%;" name="leave_type" class="form-control" id="rrr" required>
                                    <option value="" selected disabled>Select a type</option>
                                        @foreach ($leave_types as $leave_type)
                                            <option @if($count_leave[$leave_type->id]<=0) disabled class="text-danger" @endif value="{{$leave_type->id}}">{{$leave_type->name}}&nbsp;({{$count_leave[$leave_type->id]}}&nbsp;remaining)</option>
                                        @endforeach

                                </select>
                                @error('leave_type')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="rrr">
                                Leave Description
                            </label>
                            <div class="col-sm-5">
                                <textarea name="description" id="" cols="40" rows="7" class="form-control"></textarea>
                                @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="offset-sm-3">
                                <button class="btn btn-success ml-2 btn-fw" type="submit">Submit</button>
                                <button class="btn btn-warning" type="button">Cancel</button>
                            </div>
                        </div>

                    </form>

            </div>
        </div>
    </div>

</div>

@endsection
@section('js')

@endsection
