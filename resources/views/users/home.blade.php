@extends('layout')
@section('title','Home')

@section('body')
<div id="body" class="container">
 <!-- list users time table -->

<h3 class="mt-3">Search</h3>
<form id="search_form">
    {{csrf_field()}}
    <input id="pharmacy_name" class="form-control" type="text" name="pharmacy_name" placeholder="pharmacy_name" value="{{$search_pharmacy_name}}">
    <label for="date">Date</label>
    <input id="date" type="text" name="daterange" value="{{$search_date_range?$search_date_range:date('Y-m-d')}}" />
    <button class="btn btn-primary">Search</button>
</form>
<button id="reset" class="btn btn-info">Reset</button>

<!-- create time -->
<h3 class="mt-3">Create Time</h3>
<label for="date">Date</label>
<input id="create_daterange" type="text" name="create_daterange" value="{{date('Y-m-d')}}" />

<div id="rows_container">
    
</div>

<div id="list_times" class="mt-3">
@include('admin.list_times',['username'=>$user->name,'allTimes'=>$user_times])
</div>

</div>


<script>
$(function() {
  $('input[name="create_daterange"]').daterangepicker({
    opens: 'left',
    minDate: new Date(),
    "locale": {
        "format": "YYYY-MM-DD",
        
    }
  }, function(start, end, label) {
    $.ajax({
        url:"{{route('createRowsFromDateRange')}}",
        type:'POST',
        data: {'_token':"{{csrf_token()}}",'start':start.format('YYYY-MM-DD'), 'end':end.format('YYYY-MM-DD')},
        success:function(result){
            console.log(result);
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
            var user_id={{$user->id}};
            $.ajax({
                url:"{{route('times.create')}}",
                type:'GET',
                data:$(this).serialize() + "&user_id=" + user_id + "&single_user_data=" + 1,
                success:function(result){
                    if(result.return==1){
                        thisForm.remove();
                        $("#list_times").html(result.html);
                    }else if(result.return==0){
                        $("#error").html(result.html);
                        $("#error").show();
                        setTimeout(function() {
                            $('#error').fadeOut('slow');
                        }, 5000);
                    }
                    // $("body").html(result);
                }
            });
        });
    }

</script>

<script>
    $('#reset').on('click',function(){
        var user_id={{$user->id}};
        $.ajax({
            url:"{{route('home')}}",
            type:'GET',
            data:{user_id:user_id},
            success:function(result){
                if(result){
                    $("body").html(result);
                }
            }
        });
    });
    $('#search_form').on('submit',function(e){
        e.preventDefault();
        var user_id={{$user->id}};
        var daterange=$('#date').val();
        var pharmacy_name=$('#pharmacy_name').val();
        $.ajax({
            url:"{{route('home')}}",
            type:'GET',
            data:$(this).serialize() + "&user_id=" + user_id,
            success:function(result){
                if(result){
                    $("body").html(result);
                }
            }
        });
    });
    
</script>
<script>
    $(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        // autoUpdateInput: false,
        minDate: new Date(),
        "locale": {
            "format": "YYYY-MM-DD",   
        }
    });
    });
</script>


@endsection