

@extends('layouts.master')
@section('css')
@section('title')
    Holidays
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> Holidays</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">Holidays</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row text-center" >
    <div class="col-md-12 mb-30">
        <div class="card card-statistics  card-body">
            @role('admin')
            <form action="{{route('holiday.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-3">
                        <div class="input-group">
                            <input required class="form-control" placeholder="Date" autocomplete="off"  id="datepicker-action" name="holiday_date" data-date-format="yyyy-mm-dd">
                            <span class="input-group-text border-0" style="background-color: #F6F7F8;"><i class="fa fa-calendar"></i> </button></span>
                        </div>
                    </div>
                    <div class="col-3">
                        <input type="submit" value="submit" class="btn btn-success btn-lg">
                    </div>
                </div>
            </form>
            @endrole
        </div>
    </div>
</div>
<!-- row closed -->
<div class="card-body row text-center">

{{-- {{route('holiday.destroy',$post->id)}} --}}
    @foreach ( $holidays as $holiday )
        <div class="col-lg-2 grid-margin mb-3">
            <div class="card loading-transition-background">
                <div class="card-body p-2  flex holiday-info">
                    <span  style="font-size: 1.2rem;">{{$holiday->holiday_date}}
                        @role('admin')
                        <form id="delete-form-{{$holiday->id}}" action="{{ route('holiday.destroy', ['holiday' => $holiday->id]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="delete" class="btn btn-lg text-danger" style="border:none; background-color: transparent" >
                                <i class="ti-trash"></i> </button>
                        </form>
                        @endrole
                </div>
            </div>
        </div>
        @endforeach
</div>

@endsection
@section('js')
@endsection
