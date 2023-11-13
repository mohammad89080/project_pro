@extends('layouts.master')
@section('css')

    @section('title')
        {{ trans('main_trans.Create_user') }}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        {{ trans('main_trans.Create_user') }}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-body">
                        <form class="forms-sample" action="{{ route('user.store') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" for="nameInput">
                                    {{ trans('forms.Name') }}
                                </label>
                                <div class="col-sm-5">
                                    <input class="form-control" name="name" id="nameInput" placeholder="{{ trans('forms.Name') }}..." type="text" required="" autofocus="">
                                    @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" for="emailInput">
                                    {{ trans('forms.Email') }}
                                </label>
                                <div class="col-sm-5">
                                    <input class="form-control "  name="email" id="emailInput" placeholder=" {{ trans('forms.Email') }}..." type="email" required="" autocomplete="off">
                                    @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" for="confirmPasswordInput">
                                   {{ trans('forms.Password') }}
                                </label>
                                <div class="col-sm-5">
                                    <input   class="form-control " id="confirmPasswordInput" name="password" placeholder=" {{ trans('forms.Password') }}..." type="password" required="">
                                    @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
{{--                            <div class="form-group row mb-1">--}}
{{--                                <label class="col-sm-3 col-form-label text-right" for="passwordInput">--}}
{{--                                    Re-type Password--}}
{{--                                </label>--}}
{{--                                <div class="col-sm-5">--}}
{{--                                    <input  class="form-control " id="passwordInput" placeholder="Re-type Password..." type="password" required="">--}}
{{--                                </div>--}}
{{--                            </div>--}}




                            <div  class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" for="statusInput">
                               {{ trans('forms.Status') }}
                                </label>
                                <div class="col-sm-5">
                                    <select style="height: 93%;" name="status" class="form-control " id="statusInput">
                                        <option value="1">Enabled</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label text-right" for="designationInput">
                                     {{ trans('forms.Department') }}
                                </label>
                                <div class="col-sm-5">
                                    <select style="height: 93%;" name="department_id" class="form-control " id="designationInput" >
                                        <option value="" selected disabled>Select a Department</option>

                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('category') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('department_id')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-sm-3">
                                    <button class="btn btn-success ml-2 btn-fw" type="submit">Create</button>
                                    <button class="btn btn-warning" type="button">Cancel</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')

@endsection
