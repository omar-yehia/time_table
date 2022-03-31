@extends('layout')
@section('title','Times')

@section('body')
<div id="body" class="container">

@if(Session::has('success'))
    <p class="alert-success">{{Session::get('success')}}</p>
@elseif(Session::has('error'))
    <p class="alert-danger">{{Session::get('error')}}</p>
@endif

<!-- create time -->

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

<!-- {{csrf_field()}} -->

<div class="row">
    <div class="col-md-12">
        <form id="create_form">
            <div class="form-group">
                {{csrf_field()}}
                <input class="form-control" type="text" name="name" placeholder="name" required>
                <button class="btn btn-success" id="create_pharmacy_btn">Create</button>
            </div>
        </form>
    </div>

</div>



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
    
</div>

@endsection