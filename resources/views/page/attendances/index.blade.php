@extends('layouts.master')
@section('css')

    @section('title')
        {{ trans('main_trans.ReportAll') }}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        {{ trans('main_trans.ReportAll') }}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card">
                <div class="card-body" style="padding: 1rem 1.81rem;">


                    <div class="form-row align-items-center content-center">
                        @role('admin')
                        
                            
                        

                        <div class="col-sm-3 my-1 form-group">
                            
                            <select name="userSelect" id="userSelect"  style="padding-bottom: 11px;"  class="form-control" required="">
                                <option value="">--- Please Select User ---</option>
                                @foreach($users as $user )
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        
                        <div class="col-sm-3 my-1 flex">
                            <button id="reportButton"  class="btn btn-success ml-2 btn-fw" onclick="filter_users()">

                                Report
                            </button>
                            
                        </div>

                        <div class="col-sm-3 my-1 flex">
                            <a id="export" class="btn btn-info" href="#">Export to Excel</a>
                        </div>

                        <div class="col-sm-3 my-1 flex">
                            <a id="exportPdf" class="btn btn-info" href="#">Export to PDF</a>
                        </div>
                        @endrole
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        {{--                                                table-striped--}}
                        <table id="datatable" class="table  table-bordered p-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>

                                <th>Date</th>
                                <th>In Time	</th>
                                <th>Out Time</th>
                                <th>Worked</th>
                                <th>Time Late</th>


                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 0;
                                $lastDate = null;
                            @endphp

                            @foreach($attendances as $attendance)
                                @php
                                    $i++;

                                @endphp
                                <tr class="filter-data" !@role('admin') style="display:none" @endrole>
                                    <td>{{$i}}</td>
                                    <td>{{$attendance->user->name}}</td>
                                    @if ($attendance->attendance_date != $lastDate)

                                        <td>{{ $attendance->attendance_date }}</td>
                                    @else

                                        <td></td>
                                    @endif
                                    {{--                                    <td>{{$attendance->attendance_date}}</td>--}}

                                    <td>{{$attendance->start_time}}</td>
                                    <td>{{$attendance->departure_time}}</td>
                                    <td>{{$attendance->working_time}}</td>
                                    <td>{{$attendance->late_time}}</td>

                                    @php
                                        $lastDate = $attendance->attendance_date;
                                    @endphp
                                    {{--                                    <td style="color: {{ $user->status ? 'green' : 'red' }}">--}}
                                    {{--                                        {{ $user->status ? 'Active' : 'Inactive' }}--}}
                                    {{--                                    </td>--}}
                                </tr>
                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>

                                <th>Date</th>
                                <th>In Time	</th>
                                <th>Out Time</th>
                                <th>Worked</th>
                                <th>Time Late</th>

                            </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection
@section('js')
    <script>

        function filter_users()
        {
            tr = document.getElementsByClassName("filter-data");
            for (i = 0; i < tr.length; i++) {
                tr[i].style.display="table-row";
            }
            select_users=document.getElementById('userSelect');
            select_index=select_users.selectedIndex;
            user=select_users[select_index].innerText;
            user_id=select_users[select_index].value;

            var exportUrl = "{{ route('attendance.export', ['user_id' => ':user_id']) }}";
            var exportUrlPdf = "{{ route('attendance.exportPdf', ['user_id' => ':user_id']) }}";
            exportUrl = exportUrl.replace(':user_id', user_id);
            exportUrlPdf = exportUrlPdf.replace(':user_id', user_id);

            // Set the href attribute of the export link
            aa=document.getElementById("export").href = exportUrl;
            ab=document.getElementById("exportPdf").href = exportUrlPdf;

            filter = user.trim();

            var searchInputs = document.querySelectorAll('.form-control.form-control-sm');
            searchInput=searchInputs[1];
            searchInput.value=filter;
            $(function() {
                $(searchInput).keyup();
            });
            setTimeout(function() {
                // Your code to be executed after the delay
                searchInput.value='';

            }, 50);
            // tr = document.getElementsByClassName("filter-data");


            // // Loop through all table rows, and hide those who don't match the search query
            // for (i = 0; i < tr.length; i++) {
            //     td = tr[i].getElementsByTagName("td")[1];
            //     if (td) {
            //         txtValue = td.textContent || td.innerText;

            //         if (txtValue==filter) {

            //                 tr[i].style.display = "";
            //         } else {
            //                 tr[i].style.display = "none";
            //         }

            //     }
            // }
        }
    </script>

    <!-- Include the necessary scripts -->
{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    $(document).ready(function () {
        // Add a click event listener to the export button
        $("#exportButton").click(function () {
            // Use Ajax to send a request to your Laravel route for exporting
            axios.get('/export-data')
                .then(function (response) {
                    // Handle the success, you can show a success message or trigger the download directly
                    Swal.fire({
                        icon: 'success',
                        title: 'Exported Successfully!',
                        text: 'Your Excel file is ready for download.'
                    });
                })
                .catch(function (error) {
                    // Handle the error
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    });
                });
        });
    }); --}}
{{-- </script> --}}
@endsection
