

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
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            dsfdfdfsdsdfd         

        </div>
    </div>
</div>
<!-- row closed -->
<div class="card-body row text-center">
    <?php
        for ($i=0; $i <10 ; $i++) { 
   ?>

    
        <div class="col-lg-2 grid-margin mb-3" wire:loading>
            <div class="card loading-transition-background">
                <div class="card-body p-2  flex holiday-info">
                    <span  style="font-size: 1.2rem;">Dec 13, 2023
                        <form action="" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="delete" class="btn btn-lg text-danger" style="border:none; background-color: transparent" >
                                <i class="ti-trash"></i> </button>
                        </form>
                    
                </div>
            </div>
        </div>

@php
}
@endphp
</div>
@endsection
@section('js')

@endsection
