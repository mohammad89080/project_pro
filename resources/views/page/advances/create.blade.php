

@extends('layouts.master')
@section('css')
@section('title')

طلب سلفة
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->

<!-- breadcrumb -->
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                    <h5>طلب سلفة</h5> <br>

                    <form class="forms-sample" action="{{ route('advance.store') }}" method="post">
                        @csrf
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="rrr">
                                قيمة السلفة
                            </label>
                            <div class="col-sm-5">
                                <input type="number" min="1" name="amount" class="form-control">
                                @error('amount')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
            
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="rrr">
                                ملاحظات
                            </label>
                            <div class="col-sm-5">
                                <textarea name="description" id="" cols="40" rows="7" class="form-control"></textarea>
                                @error('notes')<span class="text-danger">{{ $message }}</span>@enderror
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
