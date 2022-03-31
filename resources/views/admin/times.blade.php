@extends('layout')
@section('title','Times')

@section('body')
<div id="body" class="container">

@if(session('success'))
    <p id="success" class="alert alert-success">{{session('success')}}</p>
@elseif(session('error'))
    <p id="error" class="alert alert-danger">{{session('error')}}</p>
@endif

<!-- create time -->
<h3>Create Time</h3>

<label for="user_id">User</label>
<select id="user_id" name="user_id">
    @foreach($allUsers as $user)
    <option value="{{$user->id}}">{{$user->name}}</option>
    @endforeach
</select>

<label for="date">Date</label>
<input id="date" type="text" name="daterange" value="{{date('d/m/y')}}" />

<div id="rows_container">
    
</div>


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

<script>
 

$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left',
    "locale": {
        "format": "DD/MM/YYYY",
    }
  }, function(start, end, label) {
    $.ajax({
        url:"{{route('createRowsFromDateRange')}}",
        type:'POST',
        data: {'_token':"{{csrf_token()}}",'start':start.format('YYYY-MM-DD'), 'end':end.format('YYYY-MM-DD')},
        success:function(result){
            // console.log(result);
            $("#rows_container").html(result);
            attachEvenetListener();
        }
    }); 
    //   var numberOfDays=end.diff(start, "days");
    // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
 
  });
});
</script>

<script>
    function attachEvenetListener(){
        $('.create_form').on('submit',function(e){
            e.preventDefault();
            var thisForm=$(this);
            var user_id=$('#user_id').val();
            console.log(user_id);
            $.ajax({
                url:"{{route('times.create')}}",
                type:'GET',
                data:$(this).serialize() + "&user_id=" + user_id,
                success:function(result){
                    console.log(result);
                    if(result==1){
                        thisForm.remove();
                    }
                    // $("body").html(result);
                }
            });
        });
    }

</script>
<script>
    setTimeout(function() {
      $('#success').fadeOut('slow');
    }, 2000);
    setTimeout(function() {
      $('#error').fadeOut('slow');
    }, 2000);
</script>

</div>

@endsection