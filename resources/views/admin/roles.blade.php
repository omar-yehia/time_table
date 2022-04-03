<div id="body" class="container">

<h3>Create Role</h3>
<!-- create Role -->
<div class="row">
    <div class="col-md-12">
        <form id="create_form" class="mt-3">
            <div class="form-group">
                {{csrf_field()}}
                <input class="form-control" type="text" name="name" placeholder="name" required>
                <input class="form-control" type="text" name="description" placeholder="description" required>

                <button class="btn btn-success" id="create_role_btn">Create</button>
            </div>
        </form>
    </div>

</div>

<!-- edit role -->
<div id="edit_role">
</div>

<!-- list roles -->
<div id="list_roles">
</div>


<script>
$('.select2').select2();
</script>

<script>
    function renderRoleList(){
        $.ajax({
            url:"{{route('getListOfRoles')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}"},
            success:function(result){
                if(result.return==1){
                    $("#list_roles").html(result.html);
                }
            }
        });  
    }
    renderRoleList();
</script>

<script>
    $('#create_form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"{{route('roles.create')}}",
            type:'GET',
            data:$(this).serialize(),
            success:function(result){
                $('#create_form').trigger("reset");
                renderRoleList();
                renderStats();
            }
        });
    });

</script>
    
</div>