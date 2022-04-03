
<form id='edit_admin_form'>
    <h5 class="mt-3">Edit Admin</h5>
    {{csrf_field()}}
    <div class="form-group row">
        <input type="hidden" name="admin_id" value="{{$admin->id}}">
        <div class='col-md-3'>
            <label for="name">name</label>
            <input class="form-control" type="text" name="name" placeholder="name" value="{{$admin->name}}" required>
        </div>
        <div class='col-md-3'>
            <label for="email">email</label>
            <input class="form-control" type="email" name="email" placeholder="email" value="{{$admin->email}}" required>
        </div>
        <div class='col-md-3'>
            <label for="roles">Select roles</label>
            <select id="roles" class="form-control select2" name="roles[]" multiple required>
                @foreach($all_roles as $role)
                <option value="{{$role->name}}" {{in_array($role->name,explode(',',$admin->roles)) ? 'selected':''}}>{{$role->name}}</option>
                @endforeach
            </select>
        </div>
        <div class='col-md-3'>
            <label for="password">password</label>
            <input class="form-control" type="password" name="password" placeholder="can be empty if won't update">
        </div>
    </div>
    <button class='btn btn-success'>Update</button>
</form>