

@extends('layouts.master')
@section('css')
@section('title')
    Leaves
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0"> Leaves</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">Leaves</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<div class="row">


    <div class="col mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table  table-bordered p-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Options</th> 				
                        </tr>
                        </thead>
                        <tbody>
                        @php
                        $i=0;
                        @endphp
                        
                            @php
                                $i++;
                            @endphp
                            @foreach ($leaves as $leave)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{\App\Models\User::find($leave->user_id)->name}}</td>
                                <td>{{\App\Models\LeaveType::find($leave->leave_id)->name}}</td>
                                <td><span style="color:white; font-size:1rem;"
                                    @if ($leave->status=='Pending')
                                        class="badge badge-warning p-2"
                                    @elseif ($leave->status=='Granted')
                                        class="badge badge-success p-2"
                                    @elseif ($leave->status=='Rejected')
                                        class="badge badge-danger p-2"
                                    @endif
                                >
                                    {{$leave->status}}
                                </span></td>
                                <td>{{$leave->date}}</td>
                                <td>{{$leave->description}}</td>
                                <td>
                                    <div class="dropdown" >
                                            <button id="btn-optios" style=" padding-left:12px;
                                            padding-right: 15px;" type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-primary btn-sm dropdown-toggle">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-wrench" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M.102 2.223A3.004 3.004 0 0 0 3.78 5.897l6.341 6.252A3.003 3.003 0 0 0 13 16a3 3 0 1 0-.851-5.878L5.897 3.781A3.004 3.004 0 0 0 2.223.1l2.141 2.142L4 4l-1.757.364L.102 2.223zm13.37 9.019L13 11l-.471.242-.529.026-.287.445-.445.287-.026.529L11 13l.242.471.026.529.445.287.287.445.529.026L13 15l.471-.242.529-.026.287-.445.445-.287.026-.529L15 13l-.242-.471-.026-.529-.445-.287-.287-.445-.529-.026z"></path>
                                            </svg>
                                            </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <div i class="carousel menu-resolver">
                                            <div class="carousel-inner" >

                                                <div class="carousel-item active">
                                                    
                                                  

                                                    <a class="dropdown-item"  href="#">
                                                        Update Status
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    
                                                    <form id="delete-form-{{$leave->id}}" action="{{ route('leave.destroy', ['leave' => $leave->id]) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                           
                                                        <button type="submit" title="delete" class="btn btn-lg text-danger" style="border:none; background-color: transparent" >
                                                            <i class="ti-trash"></i>Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
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
