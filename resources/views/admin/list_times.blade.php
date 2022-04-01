
<h3>List Of Times</h3>
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
            <button class="view btn btn-info">view time table</button>
            <button class="delete btn btn-info">delete</button>

        </td>
    </tr>
    @endforeach
    </tbody>
</table>