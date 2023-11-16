<!-- Table headers remain unchanged -->
<tbody>
@php $i = 0; @endphp
@foreach($attendances as $attendance)
    @php $i++; @endphp
    <tr>
        <td>{{$i}}</td>
        <td>{{$attendance->user->name}}</td>
        <td>{{$attendance->attendance_date}}</td>
        <td>{{$attendance->start_time}}</td>
        <td>{{$attendance->departure_time}}</td>
        <td>{{$attendance->working_time}}</td>
        <td>{{$attendance->late_time}}</td>
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
