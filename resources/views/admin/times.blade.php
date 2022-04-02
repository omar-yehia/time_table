
<div id="body" class="container">

<!-- search in times -->
<h3 class="mt-3">Search</h3>
<form id="search_form">
    {{csrf_field()}}
    <input id="pharmacy_name" class="form-control" type="text" name="pharmacy_name" placeholder="pharmacy_name">
    <label for="search_date">Date</label>
    <input id="search_date" type="text" name="daterange"/>
    <button class="btn btn-primary">Search</button>
</form>
<button id="reset" class="btn btn-info">Reset</button>


<!-- create time -->
<h3 class="mt-3">Create Time</h3>

<label for="user_id">User</label>
<select id="user_id" name="user_id">
    @foreach($allUsers as $user)
    <option value="{{$user->id}}">{{$user->name}}</option>
    @endforeach
</select>

<div id="error" class="alert alert-danger" style="display:none;"></div>


<label for="create_daterange">Date</label>
<input id="create_daterange" type="text" name="create_daterange" value="{{date('Y-m-d')}}" />

<div id="rows_container">
</div>

<!-- list times -->
<div id="list_times" class="mt-3"> 
</div>

<script>
    function showError(message){
        $('#error').html(message);
        $("#error").show();
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#error").offset().top
        }, 200);
        setTimeout(function() {
            $('#error').fadeOut('slow');
        }, 5000);


    }

    function renderTimeList(){
        var daterange=$('#search_date').val();
        var pharmacy_name=$('#pharmacy_name').val();
        $.ajax({
            url:"{{route('getListOfTimes')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}",'pharmacy_name':pharmacy_name,'daterange':daterange},
            success:function(result){
                if(result.return==1){
                    $("#list_times").html(result.html_list_times);
                }
            }
        });  
    }
</script>

<script>
    // daterange picker for creating times
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
                    $("#rows_container").html(result);
                    //attach event listener after element creation
                    createTimeEventListener();
                }
            });
        });
    });

    function createTimeEventListener(){
        $('.create_form').on('submit',function(e){
            e.preventDefault();
            var thisForm=$(this);
            var user_id=$('#user_id').val();
            $.ajax({
                url:"{{route('times.create')}}",
                type:'GET',
                data:$(this).serialize() + "&user_id=" + user_id,
                success:function(result){
                    console.log(result);
                    if(result.return==1){
                        thisForm.remove();
                        renderTimeList();
                    }else if(result.return==0){
                        showError(result.html);
                    }
                }
            });
        });
    }
</script>

<!-- search and reset -->
<script>
    $(function() {
        $('#search_date').daterangepicker({
            opens: 'left',
            minDate: new Date(),
            "locale": {
                "format": "YYYY-MM-DD",   
            }
        });
    });
    $('#reset').on('click',function(){
        $('#pharmacy_name').val('');
        $('#search_date').val('');
        renderTimeList();
    });
    $('#search_form').on('submit',function(e){
        e.preventDefault();
        renderTimeList();
    });    
</script>


<!-- load times list on page ready -->
<script>
$(document).ready(function(){
    $('#search_date').val('');
    renderTimeList();
});
</script>


</div>

