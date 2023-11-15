

@extends('layouts.master')
@section('css')
@section('title')
    System Settings
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">System Settings</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">System Settings</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                    <h5>{{trans('main_trans.UpdateSettings')}}</h5> <br>

                    <form class="forms-sample" action="{{ route('settings.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="nameInput">
                                {{ trans('forms.Title') }}
                            </label>
                            <div class="col-sm-5">
                                <input class="form-control" name="title" value="{{$settings->title}}" id="nameInput" placeholder="{{ trans('forms.Title') }}..." type="text" required="" autofocus="">
                                @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="nameInput">
                                {{ trans('forms.Footer') }}
                            </label>
                            <div class="col-sm-5">
                                <input class="form-control" name="footer" value="{{$settings->footer}}" id="nameInput" placeholder="{{ trans('forms.Footer') }}..." type="text" required="" autofocus="">
                                @error('footer')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="nameInput">
                                {{ trans('forms.StartTimeWork') }}
                            </label>
                            <div class="col-sm-5">
                                <input class="form-control" type="time" value="{{$settings->start_work}}" name="start_work" id="nameInput" placeholder="{{ trans('forms.StartTimeWork') }}..." type="text" required="" autofocus="">
                                @error('start_work')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="nameInput">
                                {{ trans('forms.WorkHours') }}
                            </label>
                            <div class="col-sm-5">
                                <input class="form-control" type="number" value="{{$settings->work_hours}}" min="1" max="16" name="work_hours" id="nameInput" placeholder="{{ trans('forms.WorkHours') }}..." type="text" required="" autofocus="">
                                @error('work_hours')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label text-right" for="nameInput">
                                {{ trans('forms.Logo') }}
                            </label>
                            <div class="col-sm-5">
                                <input class="form-control" type="file" min="1" max="16" name="logo" id="nameInput" placeholder="{{ trans('forms.Logo') }}..." type="text" required="" autofocus="">
                                @error('logo')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        


                        <div class="form-group row">
                            <div class="offset-sm-3">
                                <button class="btn btn-success ml-2 btn-fw" type="submit">Submit</button>
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
