@extends('layouts.master')
@section('css')

    @section('title')
        {{ trans('main_trans.SummaryReport') }}
    @stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    @section('PageTitle')
        {{ trans('main_trans.SummaryReport') }}
    @stop
    <!-- breadcrumb -->
@endsection
@section('content')

    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card">
                <div class="card-body" style="padding: 1rem 1.81rem;">
                    <input id="urlAjax" type="hidden" value="{{route('attendance.ajax_search')}}">
                    <input type="hidden" id="token_search" value="{{csrf_token()}}">
        <form action="{{ route('get-attendance') }}" method="post">
            @csrf

            <div class="form-row align-items-center mb-3">
                <div class="col-md-4">
                    <label for="startDate">Start Date:</label>
                    <input id="startDate" type="date" name="startDate" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="endDate">End Date:</label>
                    <input type="date" id="endDate" name="endDate" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <button style="width: 44%;" type="submit" class="btn btn-primary mt-4">Filter</button>
                </div>
            </div>
        </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
        <p>{{ trans('main_trans.periodFilter') }} {{ $startDate }}  {{ $endDate }}</p>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('forms.Name') }}</th>
                    <th>{{ trans('main_trans.WordHour') }}</th>
                </tr>
                </thead>
                <tbody>
          @foreach($workedMinutesByUser as $index => $result)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $result->userName }}</td>
                            <td>{{ $result->totalWorkedMinutes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
            </div>
        </div>
    </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }
    });
    $(document).ready(function() {

        // Attach an event handler to the change event of the date inputs
        $('#startDate, #endDate').on('change', function(e) {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
            var urlAjax = $('#urlAjax').val();
            var token_search = $('#token_search').val();
            // You can use startDate and endDate as needed
            console.log('Start Date:', startDate);
            console.log('End Date:', endDate);
            console.log('urlAjax:', urlAjax);
            console.log('token_search:', token_search);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                }
            });
            $.ajax({
                url: urlAjax,
                type: 'POST',
                dataType: 'html',
                cache: false,
                data: {
                    startDate: startDate,

                    '_token': token_search
                },
                success: function(data) {
                    // $("#ajax_responce_serarchDiv").html(data);
                        console.log(data)
                },
                error: function() {
                    console.log(data)
                }
            });
        });
    });
</script>
