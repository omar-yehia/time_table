@extends('layout')
@section('title','Users')

@section('body')
<div id="body" class="container">
 
<!-- create user -->
<div class="row">
    <div class="col-md-12 p-2">
        <p class="btn btn-success link_to_page" data-url="{{route('users.index')}}" >users: {{$number_of_users}}</p>
        <p class="btn btn-primary link_to_page" data-url="{{route('pharmacies.index')}}" >pharmacies: {{$number_of_pharmacies}}</p>
        <p class="btn btn-secondary link_to_page" data-url="{{route('admins.index')}}" >admins: {{$number_of_admins}}</p>
        <p class="btn btn-info link_to_page" data-url="{{route('times.index')}}" >times: {{$number_of_times}}</p>
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