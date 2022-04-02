
<h3>List Of Times</h3>
@isset($username)
<h4>for: {{$username}}</h4>
@endisset

@if(count($times))

<!-- show edit form -->
<div id="edit_time_section">
</div>


<div id="time_list_table">
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
    
    // show edit time form
    $('.delete_time_btn').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('deleteTime')}}",
            type:'post',
            data: {'_token':"{{csrf_token()}}",'id':id},
            success:function(result){
                renderTimeList();
            }
        });
    });
    // show edit time form
    $('.edit_time_btn').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('getEditTimeHTML')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}",'id':id},
            success:function(result){
                if(result.return==1){
                    $('#edit_time_section').html(result.html);
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
            $.ajax({
                url:"{{route('updateTime')}}",
                type:'POST',
                data:$(this).serialize(),
                success:function(result){
                    if(result.return==1){
                        thisForm.remove();
                        renderTimeList();
                        // $('#edit_time_section').html(result.html);
                    }else{
                        showError(result.html);
                    }
                }
            });
        });        
    }

</script>

