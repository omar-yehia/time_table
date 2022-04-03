
<form id='edit_user_form'>
    <h5 class="mt-3">Edit User</h5>
    {{csrf_field()}}
    <div class="form-group row">
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <div class='col-md-4'>
            <label for="name">name</label>
            <input class="form-control" type="text" name="name" placeholder="name" value="{{$user->name}}" required>
        </div>
        <div class='col-md-4'>
            <label for="email">email</label>
            <input class="form-control" type="email" name="email" placeholder="email" value="{{$user->email}}" required>
        </div>
        <div class='col-md-4'>
            <label for="password">password</label>
            <input class="form-control" type="password" name="password" placeholder="can be empty if won't update">
        </div>
    </div>
    <button class='btn btn-success'>Update</button>
</form>