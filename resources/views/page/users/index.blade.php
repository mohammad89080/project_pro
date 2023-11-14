@extends('layouts.master')
@section('css')

    @section('title')
        {{ trans('main_trans.Users') }}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        {{ trans('main_trans.Users') }}
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
                                <th>Name</th>

                                <th>Email</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Options</th>

                            </tr>
                            </thead>
                            <tbody>
                            @php
                            $i=0;
                            @endphp
                            @foreach($users as $user)
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->department->name}}</td>
                                    <td style="color: {{ $user->status ? 'green' : 'red' }}">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </td>

                                    <td>
                                        <div class="dropdown" >
{{--                                            --}}
                                            <button id="btn-optios" style=" padding-left:12px;
    padding-right: 15px;" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-primary btn-sm dropdown-toggle">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-wrench" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019L13 11l-.471.242-.529.026-.287.445-.445.287-.026.529L11 13l.242.471.026.529.445.287.287.445.529.026L13 15l.471-.242.529-.026.287-.445.445-.287.026-.529L15 13l-.242-.471-.026-.529-.445-.287-.287-.445-.529-.026z"></path>
                                                </svg>
                                            </button>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                    <div  class="carousel menu-resolver">
                                                        <div class="carousel-inner" >

                                                            <div class="carousel-item active">
{{--                                                                <a class="dropdown-item"  href="#">--}}
{{--                                                                IP Restriction--}}
{{--                                                                </a>--}}

                                                                <a class="dropdown-item" href="{{route('user.edit',$user->id)}}">
                                                                   Update user
                                                                </a>

{{--                                                                <a class="dropdown-item"  href="#">--}}
{{--                                                                    Update Designation--}}
{{--                                                                </a>--}}

                                                                <a class="dropdown-item text-danger" href="{{ route('user.toggleStatus', ['user' => $user->id]) }}">
                                                                    @if ($user->status)

                                                                        {{ trans('main_trans.Make_Inactive') }}
                                                                    @else

                                                                        {{ trans('main_trans.Make_Active') }}
                                                                    @endif

                                                                </a>

                                                                <a class="dropdown-item"  href="#">
                                                                   Last In Time
                                                                </a>

                                                                <a class="dropdown-item" href="#">
                                                                   Auto Punch Out Time
                                                                </a>

                                                                <a class="dropdown-item"  href="#">
                                                                    Force Punch In / Out
                                                                </a>

                                                                <a class="dropdown-item" href="{{ route('force-login', ['user' => $user->id]) }}">
                                                                  Force Login
                                                                </a>


                                                                <a class="dropdown-item text-danger btn"  href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{$user->id}}').submit();" >
                                                                    <i class="ti-trash"></i> Delete
                                                                </a>
                                                                <form id="delete-form-{{$user->id}}" action="{{ route('user.destroy', ['user' => $user->id]) }}" method="POST" style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                            </div>
                                        </div></td>
                                </tr>
                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Status</th>
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
@section('js')

@endsection
