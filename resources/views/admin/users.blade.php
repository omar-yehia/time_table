@extends('layout')
@section('title','Users')

@section('body')
<div id="body" class="container">

@if(Session::has('success'))
    <p class="alert-success">{{Session::get('success')}}</p>
@elseif(Session::has('error'))
    <p class="alert-danger">{{Session::get('error')}}</p>
@endif

<!-- create user -->
<div class="row">
    <div class="col-md-12">
        <form id="create_form">
            <!-- <form id="create_form" action="{{route('users.create')}}" method="GET"> -->
            <div class="form-group">
                {{csrf_field()}}
                <input class="form-control" type="text" name="username"></input>
                <input class="form-control" type="password" name="password"></input>
                <button class="btn btn-success" id="create_user_btn">Create</button>
            </div>
        </form>
    </div>

</div>

<!-- list users -->
<div class="text-success">
    @foreach($allUsers as $user)
        
    @endforeach
</div>
<script>
    $('#create_form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"{{route('users.create')}}",
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