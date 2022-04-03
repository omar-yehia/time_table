@php $permissions=session('admin_permissions') @endphp
@if(in_array('admins',$permissions))
<div id="body" class="container">


<h3>Create Admin</h3>
<!-- create admin -->
<div class="row">
    <div class="col-md-12">
        <form id="create_form" class="mt-3">
            <div class="form-group">
                {{csrf_field()}}
                <input class="form-control" type="text" name="name" placeholder="name" required>
                <input class="form-control" type="email" name="email" placeholder="email" required>
                <input class="form-control" type="password" name="password" placeholder="password" required>
                <label for="roles">Select roles</label>
                <select id="roles" class="form-control select2" name="roles[]" multiple required>
                    @foreach($all_roles as $role)
                    <option value="{{$role->name}}">{{$role->name}}</option>
                    @endforeach
                </select>
                <button class="btn btn-success" id="create_admin_btn">Create</button>
            </div>
        </form>
    </div>

</div>

<!-- edit admin -->
<div id="edit_admin">
</div>

<!-- list admins -->
<div id="list_admins">
</div>
 
<script>
$('.select2').select2();
</script>

<script>
    function renderAdminList(){
        $.ajax({
            url:"{{route('getListOfAdmins')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}"},
            success:function(result){
                if(result.return==1){
                    $("#list_admins").html(result.html);
                }
            }
        });  
    }
    renderAdminList();
</script>

<script>
    $('#create_form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"{{route('admins.create')}}",
            type:'GET',
            data:$(this).serialize(),
            success:function(result){
                $('#create_form').trigger("reset");
                renderAdminList();
                renderStats();
            }
        });
    });

</script>
    
</div>
@endif