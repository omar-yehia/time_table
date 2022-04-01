<div id="body" class="container">

@if(Session::has('success'))
    <p class="alert-success">{{Session::get('success')}}</p>
@elseif(Session::has('error'))
    <p class="alert-danger">{{Session::get('error')}}</p>
@endif

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

    <!-- list roles -->
    <h3 class="mt-3">Roles</h3>
    
    <div class="text-success">

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
        @foreach($all_roles as $role)
        <tr>
        <th scope="row">{{1+$loop->index}}</th>
            <td>{{$role->name}}</td>
            <td>{{$role->description}}</td>
            <td>
                <button class="edit btn btn-info">edit</button>
                <button class="view btn btn-info">view time table</button>
                <button class="delete btn btn-danger">delete</button>

            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
$('.select2').select2();
</script>
<script>
    $('#create_form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"{{route('roles.create')}}",
            type:'GET',
            data:$(this).serialize(),
            success:function(result){
                if(result.return==1){
                    var number=$('#number_of_roles').data('number');
                    $('#number_of_roles').text(++number);
                    $("#admin_app_container").html(result.html);
                }
            }
        });
    });
</script>
    
</div>