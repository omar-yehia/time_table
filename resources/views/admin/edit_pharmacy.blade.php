<h5 class="mt-3">Edit Pharmacy</h5>
<form id='edit_pharmacy_form'>
    {{csrf_field()}}
    <div class="form-group row">
        <input type="hidden" name="pharmacy_id" value="{{$pharmacy->id}}">
        <div class='col-md-4'>
            <label for="name">name</label>
            <input class="form-control" type="text" name="name" placeholder="name" value="{{$pharmacy->name}}" required>
        </div>
    </div>
    <button class="btn btn-success">Update</button>
</form>