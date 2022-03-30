@extends('layout')
@section('title','Times')

@section('body')
<div id="body" class="container">

@if(Session::has('success'))
    <p class="alert-success">{{Session::get('success')}}</p>
@elseif(Session::has('error'))
    <p class="alert-danger">{{Session::get('error')}}</p>
@endif

<!-- create time -->

<select>
    @foreach($allUsers as $user)
    <option value="{{$user->id}}">{{$user->name}}</option>
    @endforeach
</select>
<input type="text"> </input>
<div class="row">
    <div class="col-md-12">
        <form id="create_form">
            <div class="form-group">
                {{csrf_field()}}
                <input class="form-control" type="text" name="name" placeholder="name" required>
                <button class="btn btn-success" id="create_pharmacy_btn">Create</button>
            </div>
        </form>
    </div>

</div>


<script>
    $('#create_form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"{{route('pharmacies.create')}}",
            type:'GET',
            data:$(this).serialize(),
            success:function(result){
                $("body").html(result);
            }
        });
    });
</script>
    
</div>

@endsection