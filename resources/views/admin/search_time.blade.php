<!-- search time list -->
<h3 class="mt-3">Search</h3>
<form id="search_form">
    {{csrf_field()}}
    <input id="pharmacy_name" class="form-control" type="text" name="pharmacy_name" placeholder="pharmacy_name" value="{{$search_pharmacy_name}}">
    <label for="search_date">Date</label>
    <input id="search_date" type="text" name="daterange" value="{{$search_date_range?$search_date_range:date('Y-m-d')}}" />
    <button class="btn btn-primary">Search</button>
</form>
<button id="reset" class="btn btn-info">Reset</button>

<script>
    $(function() {
        $('#search_date').daterangepicker({
            opens: 'left',
            // autoUpdateInput: false,
            minDate: new Date(),
            "locale": {
                "format": "YYYY-MM-DD",   
            }
        });
    });
</script>


<script>
     $('#reset').on('click',function(){
        $('#pharmacy_name').val('');
        $('#search_date').val('');
        renderTimeList();
        // var user_id={ {$user->id}};
        // $.ajax({
        //     url:"{{route('home')}}",
        //     type:'GET',
        //     data:{user_id:user_id},
        //     success:function(result){
        //         if(result){
        //             $("body").html(result);
        //         }
        //     }
        // });
    });
    $('#search_form').on('submit',function(e){
        e.preventDefault();
        renderTimeList();
    });
    
    // $('#search_form').on('submit',function(e){
    //     e.preventDefault();
    //     // var user_id={ {$user->id}};
    //     var daterange=$('#date').val();
    //     var pharmacy_name=$('#pharmacy_name').val();
    //     $.ajax({
    //         url:"{{route('home')}}",
    //         type:'GET',
    //         data:$(this).serialize() + "&user_id=" + user_id,
    //         success:function(result){
    //             if(result){
    //                 $("body").html(result);
    //             }
    //         }
    //     });
    // });
    
</script>