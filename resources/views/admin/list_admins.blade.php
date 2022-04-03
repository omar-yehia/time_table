<h3 class="mt-5">List of admins</h3>
<table class="table table-striped">
    <thead>
    <tr>
    <th scope="col">#</th>
    <th scope="col">name</th>
    <th scope="col">email</th>
    <th scope="col">roles</th>
    <th scope="col">actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($admins as $admin)
    <tr>
    <th scope="row">{{1+$loop->index}}</th>
        <td>{{$admin->name}}</td>
        <td>{{$admin->email}}</td>
        <td>{{$admin->roles}}</td>
        <td>
            <button data-id="{{$admin->id}}" class="edit btn btn-info">edit</button>
            <button data-id="{{$admin->id}}" class="delete btn btn-danger">delete</button>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>


<script>
    $('.delete').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('deleteAdmin')}}",
            type:'post',
            data: {'_token':"{{csrf_token()}}",'id':id},
            success:function(result){
                renderAdminList();
                renderStats();
            }
        });
    });
    // show edit admin form
    $('.edit').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('editAdmin')}}",
            type:'GET',
            data:{id:id},
            success:function(result){
                if(result.return==1){
                    $("#edit_admin").html(result.html);
                    scrollToElement('edit_admin');
                    eventListenerForUpdateAdmin();
                }else{
                    showError(result.html);
                }
            }
        });
    });
    function eventListenerForUpdateAdmin(){
        //submit edit admin form
        $('#edit_admin_form').on('submit',function(e){
            e.preventDefault();
            var thisForm=$(this);
            $.ajax({
                url:"{{route('updateAdmin')}}",
                type:'POST',
                data:$(this).serialize(),
                success:function(result){
                    if(result.return==1){
                        thisForm.remove();
                        renderAdminList();
                        renderStats();
                    }else{
                        showError(result.html);
                    }
                }
            });
        });        
    }

</script>
 