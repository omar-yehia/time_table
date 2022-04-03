@php $permissions=session('admin_permissions') @endphp
@if(in_array('times',$permissions))
<div id="body" class="container">

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

<!-- search times -->
<div id="search_times" class="mt-3"> 
</div>

<!-- list times -->
<div id="list_times" class="mt-3"> 
</div>

<script>
    function renderSearchTime(){
        $.ajax({
            url:"{{route('getSearchTimeForm')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}"},
            success:function(result){
                if(result.return==1){
                    $("#search_times").html(result.html);
                }
            }
        });  
    }
    renderSearchTime();

    function renderTimeList(){
        var daterange=$('#search_date').val();
        var pharmacy_name=$('#pharmacy_name').val();
        $.ajax({
            url:"{{route('getListOfTimes')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}",'pharmacy_name':pharmacy_name,'daterange':daterange},
            success:function(result){
                if(result.return==1){
                    $("#list_times").html(result.html);
                }
            }
        });
    }
    renderTimeList();
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
                        renderStats();
                    }else if(result.return==0){
                        showError(result.html);
                    }
                }
            });
        });
    }
</script>
 
 
</div>
@endif