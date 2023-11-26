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
    @php
   function time2($time)
   {
            $totalWorkedSeconds = $time ?? 0;

    $hours = floor($totalWorkedSeconds / 3600);
    $minutes = floor(($totalWorkedSeconds % 3600) / 60);
    $seconds = $totalWorkedSeconds % 60;


            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
   }

    @endphp
    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card">
                <div class="card-body" style="padding: 1rem 1.81rem;">


                    <div class="form-row align-items-center content-center">
                        @role('admin')
                        
                            
                        

                        <div class="col-sm-3 my-1 form-group">

                            <select style="font-size: 14px;font-weight: 900;padding-bottom: 7px;" name="userSelect" id="userSelect"  style=""  class="form-control" required="">
                                <option value="">{{ trans('main_trans.PleaseSelectUser') }}</option>
                                @foreach($users as $user )
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-sm-3 my-1 flex">
                            <button style="font-size: 17px" id="reportButton"  class="btn btn-success ml-2 btn-fw" onclick="filter_users()">
                                {{ trans('main_trans.ReportPerson') }}

                            </button>

                        </div>

                        <div class="col-sm-3 my-1 flex">
                            <a id="export" style="font-size: 17px" class="btn btn-info" href="#">{{ trans('main_trans.ExporttoExcel') }}</a>
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
                                <th>   {{ trans('forms.Name') }}</th>

                                <th> {{ trans('main_trans.Date') }}</th>
                                <th> {{ trans('main_trans.InTime') }}</th>
                                <th>{{ trans('main_trans.OutTime') }}</th>
                                <th> {{ trans('main_trans.Worked') }}</th>
                                <th> {{ trans('main_trans.TimeLate') }}</th>


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
                                    <td>{{$attendance->user->name}}<span class="d-none">{{$attendance->user->id}}</span></td>
                                    @if ($attendance->attendance_date != $lastDate)

                                        <td>{{ $attendance->attendance_date }}</td>
                                    @else

                                        <td></td>
                                    @endif
                                    {{--                                    <td>{{$attendance->attendance_date}}</td>--}}

                                    <td>{{$attendance->start_time}}</td>
                                    <td>{{$attendance->departure_time}}</td>

                                <td>{{time2($attendance->working_time)}}</td>


                                <td>{{time2($attendance->late_time)}}</td>
                                    @php
                                        $lastDate = $attendance->attendance_date;
                                    @endphp

                            @endforeach


                            </tbody>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>   {{ trans('forms.Name') }}</th>

                                <th> {{ trans('main_trans.Date') }}</th>
                                <th> {{ trans('main_trans.InTime') }}</th>
                                <th>{{ trans('main_trans.OutTime') }}</th>
                                <th> {{ trans('main_trans.Worked') }}</th>
                                <th> {{ trans('main_trans.TimeLate') }}</th>

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
            user_id=select_users[select_index].value;
            user=select_users[select_index].innerText+user_id;

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
            }, 10);

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
