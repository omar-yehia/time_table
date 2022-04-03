<h3 class="mt-5">List of roles</h3>
<!-- list roles -->
<table class="table table-striped">
    <thead>
    <tr>
    <th scope="col">#</th>
    <th scope="col">Name</th>
    <th scope="col">Description</th>
    <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach($roles as $role)
    <tr>
    <th scope="row">{{1+$loop->index}}</th>
        <td>{{$role->name}}</td>
        <td>{{$role->description}}</td>
        <td>
            <button data-id="{{$role->id}}" class="edit btn btn-info">edit</button>
            <button data-id="{{$role->id}}" class="delete btn btn-danger">delete</button>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

<script>
    $('.delete').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('deleteRole')}}",
            type:'post',
            data: {'_token':"{{csrf_token()}}",'id':id},
            success:function(result){
                renderRoleList();
                renderStats();
            }
        });
    });
    // show edit role form
    $('.edit').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('editRole')}}",
            type:'GET',
            data:{id:id},
            success:function(result){
                if(result.return==1){
                    $("#edit_role").html(result.html);
                    scrollToElement('edit_role');
                    eventListenerForUpdateRole();
                }else{
                    showError(result.html);
                }
            }
        });
    });
    function eventListenerForUpdateRole(){
        //submit edit role form
        $('#edit_role_form').on('submit',function(e){
            e.preventDefault();
            var thisForm=$(this);
            $.ajax({
                url:"{{route('updateRole')}}",
                type:'POST',
                data:$(this).serialize(),
                success:function(result){
                    if(result.return==1){
                        thisForm.remove();
                        renderRoleList();
                        renderStats();
                    }else{
                        showError(result.html);
                    }
                }
            });
        });        
    }

</script>
 