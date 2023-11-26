<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>
</head>
<body>

<h2>{{$attendances[0]->user->name}}</h2>


<table style="width:100%">
    <tr>
        <th>#</th>

        <th>Date</th>
        <th>In Time	</th>
        <th>Out Time</th>
        <th>Worked</th>
        <th>Time Late</th>
    </tr>

        <tbody>
        @php
            $i = 0;
            $lastDate = null;
        @endphp

        @foreach($attendances as $attendance)
            @php
                $i++;

            @endphp
            <tr>
                <td>{{$i}}</td>
                @if ($attendance->attendance_date != $lastDate)
                    <td>{{ $attendance->attendance_date }}</td>
                @else

                    <td></td>
                @endif

                <td>{{$attendance->start_time}}</td>
                <td>{{$attendance->departure_time}}</td>
                <td>{{$attendance->working_time}}</td>
                <td>{{$attendance->late_time}}</td>

                @php
                    $lastDate = $attendance->attendance_date;
                @endphp

            </tr>
        @endforeach


        </tbody>

    </table>

</body>
</html>