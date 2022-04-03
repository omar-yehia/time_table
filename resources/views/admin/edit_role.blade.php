<form id='edit_role_form'>
    <h5 class="mt-3">Edit Role</h5>
    {{csrf_field()}}
    <div class="form-group row">
        <input type="hidden" name="role_id" value="{{$role->id}}">
        <div class='col-md-4'>
            <label for="name">name</label>
            <input class="form-control" type="text" name="name" placeholder="name" value="{{$role->name}}" required>
        </div>
        <div class='col-md-4'>
            <label for="name">description</label>
            <input class="form-control" type="text" name="description" placeholder="description" value="{{$role->description}}" required>
        </div>
    </div>
    <button class='btn btn-success'>Update</button>
</form>