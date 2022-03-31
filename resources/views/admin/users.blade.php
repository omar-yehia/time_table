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
                <input class="form-control" type="text" name="name" placeholder="name" required>
                <input class="form-control" type="email" name="email" placeholder="email" required>
                <input class="form-control" type="password" name="password" placeholder="password" required>
                <button class="btn btn-success" id="create_user_btn">Create</button>
            </div>
        </form>
    </div>

</div>

<!-- list users -->

<table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">name</th>
        <th scope="col">email</th>
        <th scope="col">actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($allUsers as $user)
        <tr>
            <th scope="row">{{1+$loop->index}}</th>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                <button class="edit btn btn-info">edit</button>
                <button class="view btn btn-info">view time table</button>
                <button class="delete btn btn-danger">delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#create_form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"{{route('users.create')}}",
            type:'GET',
            data:$(this).serialize(),
            success:function(result){
                $("#admin_app_container").html(result);
            }
        });
    });

    $('.view').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"{ {route('viewUserTimeTable')}}",
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