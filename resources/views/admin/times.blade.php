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

<label for="user">User</label>
<select id="user" name="user_id">
    @foreach($allUsers as $user)
    <option value="{{$user->id}}">{{$user->name}}</option>
    @endforeach
</select>

<label for="date">Date</label>
<input id="date" type="text" name="daterange" value="{{date('d/m/y')}}" />

{{csrf_field()}}

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
    function createRow(date,day){
        var row=`
        <div class="row">
            <div class="col-md-1">`+date+`</div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
        </div>
        <td>
        </td>
        `;
        $('#create_table').append();

    }

$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    $.ajax({
        url:"{{route('createRowsFromDateRange')}}",
        type:'POST',
        data: {'start':start.format('YYYY-MM-DD'), 'end':end.format('YYYY-MM-DD')},
        success:function(result){
            $("rows_container").html(result);
        }
    });
    console.log();
    //   var numberOfDays=end.diff(start, "days");
    //   for(var i=0;i<numberOfDays;i++){
    //     createRow();
    //   }
    // //   
    // // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    // console.log();
    // var start = moment("2013-11-03");
    // var end = moment("2013-11-04");
    // end.diff(start, "days")
  });
});
</script>

<script>
    $('#create_form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"{{route('pharmacies.create')}}",
            type:'GET',
            data:$(this).serialize(),
            success:function(result){
                $("body").html(result);
            }
        });
    });
</script>
    
</div>

@endsection