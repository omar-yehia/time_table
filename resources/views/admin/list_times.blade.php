
<h3>List Of Times</h3>
@isset($username)
<h4>for: {{$username}}</h4>
@endisset

@if(count($allTimes))
<!-- times list -->
<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">date</th>
        <th scope="col">day</th>
        <th scope="col">user</th>
        <th scope="col">pharmacy</th>
        <th scope="col">start_time</th>
        <th scope="col">end_time</th>
        <th scope="col">actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($allTimes as $time)
    <tr>
    <th scope="row">{{1+$loop->index}}</th>
        <td>{{$time->date}}</td>
        <td>{{$time->day}}</td>
        <td>{{$time->user}}</td>
        <td>{{$time->pharmacy}}</td>
        <td>{{$time->start_time}}</td>
        <td>{{$time->end_time}}</td>
        <td>
            <button class="edit btn btn-info">edit</button>
            <button class="delete btn btn-danger">delete</button>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<h2 class="text-warning">No Times found</h2>
@endif