

@extends('layouts.master')
@section('css')

@section('title')
    Leaves
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->

<!-- breadcrumb -->
@endsection
@section('content')

<div class="row">
    <div class="col-xl-12 mb-30">
        <div class="card">
            <div class="card-body" style="padding: 1rem 1.81rem;">


                <div class="form-row align-items-center content-center ">
                    <div class="col-sm-2 my-1 form-group">

                        <select  id="catSelect" class="form-control pb-2" onchange="filter_table('catSelect','2')">
                            <option value="" class="text-center">---Category---</option>
                            @foreach($leave_types as $type )
                                <option value="{{$type->name}}"> {{$type->name}} </option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-sm-2 my-1 form-group">

                        <select id="statSelect" class="form-control pb-2" onchange="filter_table('statSelect','3')">
                            <option value="" class="text-center">---Status---</option>
                                <option value="Granted">Granted</option>
                                <option value="Pending">Pending</option>
                                <option value="Rejected">Rejected</option>
                        </select>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


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
                            <tr class="filter-data">
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
<script>

    function filter_table(idd,idx)
        {

            select_filter=document.getElementById(idd);
            select_index=select_filter.selectedIndex;
            data=select_filter[select_index].value;

            filter = data.trim();

            // var tr = document.querySelectorAll('.filter-data:not(.nshow)');
            tr=document.getElementsByClassName("filter-data");



            // Loop through all table rows, and hide those who don't match the search query
            count=0;
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[idx];
                if (td) {

                    txtValue = td.textContent || td.innerText;
                    txtValue=txtValue.trim();

                    if (txtValue==filter || filter=="") {

                            tr[i].classList.remove("nshow");
                            count++;
                    } else {
                            tr[i].classList.add("nshow");
                    }

                }
            }
            document.getElementById("datatable_info").innerText="Showing "+ count+ " entries (filtered from "+tr.length+" total entries)";
        }
</script>
@endsection
