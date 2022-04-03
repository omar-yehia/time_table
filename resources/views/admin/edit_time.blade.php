<form id='edit_time_form'>
    <h5 class="mt-1">Edit Time</h5>

    {{csrf_field()}}
    <input type="hidden" name="time_id" value="{{$time->id}}">
    <label for="date">Date</label>
    <input id="edit_daterange" type="text" name="date" />
    <div class='row'>
        <div class='col-md-2'>
            <select name='pharmacy_id' required>
                @foreach($allPharmacies  as $pharmacy)
                <option value="{{$pharmacy->id}}" {{$time->pharmacy_id==$pharmacy->id ? 'selected':''}}>{{$pharmacy->name}}</option>
                @endforeach
            </select>
        </div>
        @if(session('admin_permissions') && in_array('users',session('admin_permissions')))
        <div class='col-md-2'>
            <select name='user_id' required>
                @foreach($allUsers as $user)
                <option value="{{$user->id}}" {{$time->user_id==$user->id ? 'selected':''}}>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        @else
        <input type="hidden" value="{{$time->user_id}}" name="user_id">
        @endif
        <div class='col-md-2'>
            <input type='time' name='start_time' value="{{$time->start_time}}" required>
        </div>
        <div class='col-md-2'>
            <input type='time' name='end_time' value="{{$time->end_time}}" required>
        </div>
        <div class='col-md-2'><button class="btn btn-success">Update</button></div>
    </div>

</form>
<script>
$(function() {
  $('#edit_daterange').daterangepicker({
    opens: 'left',
    singleDatePicker: true,
    startDate: "{{$time->date}}",
    minDate: new Date(),
    "locale": {
        "format": "YYYY-MM-DD",
    }
  });
});
</script>
