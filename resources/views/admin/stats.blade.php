<div class="col-md-12 p-2">
    <p class="btn btn-secondary link_to_page" data-url="{{route('admins.index')}}" >admins: {{$number_of_admins}}</p>
    <p class="btn btn-info link_to_page" data-url="{{route('roles.index')}}" >roles: {{$number_of_roles}}</p>
    <p class="btn btn-info link_to_page" data-url="{{route('times.index')}}" >times: {{$number_of_times}}</p>
    <p class="btn btn-success link_to_page" data-url="{{route('users.index')}}" >users: {{$number_of_users}}</p>
    <p class="btn btn-primary link_to_page" data-url="{{route('pharmacies.index')}}" >pharmacies: {{$number_of_pharmacies}}</p>
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
