

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
                            @role('admin')
                            <th>Options</th> 		
                            @endrole		
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
                                @role('admin')
                                <td>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Update Status
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                          <a class="dropdown-item" href="{{ route('update_leave_status', ['id' => $leave->id, 'status' => 'Granted']) }}">Granted</a>
                                          <a class="dropdown-item" href="{{ route('update_leave_status', ['id' => $leave->id, 'status' => 'Pending']) }}">Pending</a>
                                          <a class="dropdown-item" href="{{ route('update_leave_status', ['id' => $leave->id, 'status' => 'Rejected']) }}">Rejected</a>
                                        </div>
                                    </div>
                                                    
                                                    <form id="delete-form-{{$leave->id}}" action="{{ route('leave.destroy', ['leave' => $leave->id]) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                           
                                                        <button type="submit" title="delete" class="btn btn-md btn-danger" >Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    </div>
                    
                                </td>
                                @endrole
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
