@extends('layout')
@section('title','Users')

@section('body')
<div id="body" class="container">
 
<div id="error" class="alert alert-danger" style="display:none;"></div>
<!-- stats -->
<div class="row">
    <div class="col-md-12 p-2">
        <p class="btn btn-secondary link_to_page" data-url="{{route('admins.index')}}" >admins: <span data-number="{{$number_of_admins}}" id="number_of_admins">{{$number_of_admins}}</span></p>
        <p class="btn btn-info link_to_page" data-url="{{route('roles.index')}}" >roles: <span data-number="{{$number_of_roles}}" id="number_of_roles">{{$number_of_roles}}</span></p>
        <p class="btn btn-info link_to_page" data-url="{{route('times.index')}}" >times: <span data-number="{{$number_of_times}}" id="number_of_times">{{$number_of_times}}</span></p>
        <p class="btn btn-success link_to_page" data-url="{{route('users.index')}}" >users: <span data-number="{{$number_of_users}}" id="number_of_users">{{$number_of_users}}</span></p>
        <p class="btn btn-primary link_to_page" data-url="{{route('pharmacies.index')}}" >pharmacies: <span data-number="{{$number_of_pharmacies}}" id="number_of_pharmacies">{{$number_of_pharmacies}}</span></p>
    </div>
</div>
<div class="row">
    <div id="admin_app_container" class="col-md-12 p-2">
        Welcome back!
    </div>
</div>

<script>

    $('.link_to_page').on('click',function(e){
        url=$(this).data('url');
        $.ajax({
            url:url,
            type:'GET',
            // data:$(this).serialize(),
            success:function(result){
                $("#admin_app_container").html(result);
            }
        });
    });
    
</script>
    
</div>

@endsection