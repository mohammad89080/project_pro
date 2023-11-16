
@extends('layouts.master')
@section('css')

    @section('title')
        {{ trans('main_trans.Department') }}
    @stop
@endsection
@section('page-header')
<!-- breadcrumb -->
    @section('PageTitle')
        {{ trans('main_trans.Department') }}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-5 grid-margin">
            <div  class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ trans('main_trans.Create_New_Designation') }}</h4>
                    <p class="card-description"> </p>
                    <form class="forms-sample" action="{{ route('department.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="nameInput">
                                {{ trans('forms.Name') }}
                            </label>
                            <div class="col-sm-8">
                                <input  class="form-control" name="name" id="nameInput" placeholder="{{ trans('forms.Name') }}..." type="text"  autocomplete="false" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-3">
                                <button class="btn btn-success ml-2 btn-fw" type="submit">
                                    {{ trans('main_trans.Create_Department') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>    </div>
        <div class="col-xl-6 mb-30 ">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="table-responsive">
{{--                                                table-striped--}}
                        <table id="datatable" class="table  table-bordered p-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>

                                <th>Options</th>

                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach($dpartemnts as $department)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$department->name}}</td>
                                    <td>
{{--                                    <a class="btn btn-info"  href="#">--}}
{{--                            Update Designation--}}
{{--                            </a>--}}


                                                            <a class="btn btn-danger"  href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{$department->id}}').submit();" >
                                                                        {{ trans('main_trans.Delete_Department') }}
                                                            </a>
                                                            <form id="delete-form-{{$department->id}}" action="{{ route('department.destroy', ['department' => $department->id]) }}" method="POST" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')

                                                            </form>

                                    </td>



                                </tr>
                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Options</th>
                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
