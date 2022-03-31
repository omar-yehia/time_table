@extends('layout')
@section('title','Login')

@section('body')
<div id="body" class="container">
 
@if(session('success'))
    <p id="success" class="alert alert-success">{{session('success')}}</p>
@elseif(session('error'))
    <p id="error" class="alert alert-danger">{{session('error')}}</p>
@endif

<form class="p-3" action="{{route('login')}}" method="POST">
    {{csrf_field()}}
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
  </div>
  <div class="form-group">
  <label for="user">User</label>
  <input id="user" type="radio" name="accounttype" value="user" checked>
  <label for="admin">Admin</label>
  <input id="admin" type="radio" name="accounttype" value="admin">
</div>
  <button type="submit" class="btn btn-primary w-50 mt-1">Submit</button>
</form>

</div>

<script>
    setTimeout(function() {
      $('#success').fadeOut('slow');
    }, 2000);
    setTimeout(function() {
      $('#error').fadeOut('slow');
    }, 2000);
</script>

@endsection