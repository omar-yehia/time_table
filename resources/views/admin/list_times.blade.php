
<h3>List Of Times</h3>
@if(isset($timeOwner) && $timeOwner)
<h4>for: {{$timeOwner}}</h4>
@endif
 

@if(count($times))

<!-- show edit form -->
<div id="edit_time_section">
</div>


<div id="time_list_table">
<!-- times list -->
<table class="table table-striped">
        <input type="hidden" id="owner_user_id" name="owner_user_id" value="{{$owner_user_id}}">
        <input type="hidden" id="owner_pharmacy_id" name="owner_pharmacy_id" value="{{$owner_pharmacy_id}}">
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
    @foreach($times as $time)
    <tr>
    <th scope="row">{{1+$loop->index}}</th>
        <td>{{$time->date}}</td>
        <td>{{$time->day}}</td>
        <td>{{$time->user}}</td>
        <td>{{$time->pharmacy}}</td>
        <td>{{$time->start_time}}</td>
        <td>{{$time->end_time}}</td>
        <td>
            @if(date('Y-m-d',strtotime($time->date)) >=date('Y-m-d'))
            <button data-id="{{$time->id}}" class="edit_time_btn btn btn-info">edit</button>
            <button data-id="{{$time->id}}" class="delete_time_btn btn btn-danger">delete</button>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<h2 class="text-warning">No Times found</h2>
@endif
</div>


<script>
    $('.delete_time_btn').on('click',function(){
        var id=$(this).data('id');
        var owner_user_id=$('#owner_user_id').val();
        var owner_pharmacy_id=$('#owner_pharmacy_id').val();
        $.ajax({
            url:"{{route('deleteTime')}}",
            type:'post',
            data: {'_token':"{{csrf_token()}}",'id':id},
            success:function(result){
                renderTimeList(owner_user_id,owner_pharmacy_id);
                renderStats();
            }
        });
    });
    // show edit time form
    $('.edit_time_btn').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('editTime')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}",'id':id},
            success:function(result){
                if(result.return==1){
                    $('#edit_time_section').html(result.html);
                    scrollToElement('edit_time_section');
                    attachEvenetListener2();
                }
            }
        });
    });
    function attachEvenetListener2(){
        //submit edit time form
        $('#edit_time_form').on('submit',function(e){
            e.preventDefault();

            var thisForm=$(this);
            var owner_user_id=$('#owner_user_id').val();
            var owner_pharmacy_id=$('#owner_pharmacy_id').val();
            $.ajax({
                url:"{{route('updateTime')}}",
                type:'POST',
                data:$(this).serialize(),
                success:function(result){
                    if(result.return==1){
                        thisForm.remove();
                        renderTimeList(owner_user_id,owner_pharmacy_id);
                        renderStats();
                    }else{
                        showError(result.html);
                    }
                }
            });
        });        
    }

</script>