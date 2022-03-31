@extends('layout')
@section('title','Pharmacies')

@section('body')
<div id="body" class="container">

@if(Session::has('success'))
    <p class="alert-success">{{Session::get('success')}}</p>
@elseif(Session::has('error'))
    <p class="alert-danger">{{Session::get('error')}}</p>
@endif

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
                <select id="roles" class="form-control select2" name="roles[]" multiple>
                    @foreach($all_roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
                <button class="btn btn-success" id="create_admin_btn">Create</button>
            </div>
        </form>
    </div>

</div>

    <!-- list admins -->
    <h3 class="mt-3">Admins</h3>
    
    <div class="text-success">

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
        @foreach($all_admins as $admin)
        <tr>
        <th scope="row">{{1+$loop->index}}</th>
            <td>{{$admin->name}}</td>
            <td>{{$admin->email}}</td>
            <td>{{$admin->roles}}</td>
            <td>
                <button class="edit btn btn-info">edit</button>
                <button class="view btn btn-info">view time table</button>
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
            url:"{{route('admins.create')}}",
            type:'GET',
            data:$(this).serialize(),
            success:function(result){
                $("#admin_app_container").html(result);
            }
        });
    });
</script>
    
</div>

@endsection