<h3 class="mt-5">List of users</h3>
<table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">name</th>
        <th scope="col">email</th>
        <th scope="col">actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <th scope="row">{{1+$loop->index}}</th>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                <button data-id="{{$user->id}}" class="edit btn btn-info">edit</button>
                <button data-id="{{$user->id}}" class="view btn btn-primary" data-id="{{$user->id}}">view time table</button>
                <button data-id="{{$user->id}}" class="delete btn btn-danger">delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<script>
    $('.delete').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('deleteUser')}}",
            type:'post',
            data: {'_token':"{{csrf_token()}}",'id':id},
            success:function(result){
                renderUserList();
                renderStats();
            }
        });
    });
    // show edit user form
    $('.edit').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('editUser')}}",
            type:'GET',
            data:{id:id},
            success:function(result){
                if(result.return==1){
                    $("#edit_user").html(result.html);
                    scrollToElement('edit_user');
                    eventListenerForUpdateUser();
                }else{
                    showError(result.html);
                }
            }
        });
    });
    function eventListenerForUpdateUser(){
        //submit edit user form
        $('#edit_user_form').on('submit',function(e){
            e.preventDefault();
            var thisForm=$(this);
            $.ajax({
                url:"{{route('updateUser')}}",
                type:'POST',
                data:$(this).serialize(),
                success:function(result){
                    if(result.return==1){
                        thisForm.remove();
                        renderUserList();
                        renderStats();
                    }else{
                        showError(result.html);
                    }
                }
            });
        });        
    }

</script>
 