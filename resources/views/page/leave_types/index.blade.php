

@extends('layouts.master')
@section('css')
@section('title')

    {{trans('main_trans.LeaveTypes')}}

@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        {{trans('main_trans.LeaveTypes')}}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')
<div class="row">
    <div class="col-5 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                    <h5>{{trans('main_trans.CreateLeaveType')}}</h5> <br>

                    <form class="forms-sample" action="{{ route('leave-types.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right" for="nameInput">
                                {{ trans('forms.Name') }}
                            </label>
                            <div class="col-sm-6">
                                <input class="form-control" name="name" id="nameInput" placeholder="{{ trans('forms.Name') }}..." type="text" required="" autofocus="">
                                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label text-right" for="nameInput">
                                {{ trans('forms.maximum_in_year') }}
                            </label>
                            <div class="col-sm-6">
                                <input type="number" class="form-control" name="maximum" id="nameInput" placeholder="{{ trans('forms.maximum_in_year') }}..." type="text" required="" autofocus="">
                                @error('maximum')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <div class="offset-sm-3">
                                <button style="width: 110px; font-size: 19px;" class="btn btn-success ml-2 btn-fw" type="submit">{{ trans('forms.Create') }}</button>
{{--                                <button class="btn btn-warning" type="button">Cancel</button>--}}
                            </div>
                        </div>

                    </form>

            </div>
        </div>
    </div>


    <div class="col-7 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table  table-bordered p-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ trans('forms.Name') }}</th>
                            <th> {{ trans('forms.maximum_in_year') }}</th>
                            <th>{{ trans('main_trans.Options') }}</th>

                        </tr>
                        </thead>
                        <tbody>
                        @php
                        $i=0;
                        @endphp
                        @foreach ($leave_types as $type )

                            @php
                                $i++;
                            @endphp
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$type->name}}</td>
                                <td>{{$type->maximum}}</td>
                                <td>
                                    @role('admin')
                                    <form id="delete-form-{{$type->id}}" action="{{ route('leave-types.destroy', ['leave_type' => $type->id]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="delete" class="btn btn-lg text-danger" style="border:none; background-color: transparent" >
                                            <i class="ti-trash"></i> </button>
                                    </form>
                                    @endrole
                                </td>

                            </tr>

                        @endforeach
                        </tbody>
                        <tfoot>

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
