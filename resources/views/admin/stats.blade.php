<div class="col-md-12 p-2">
    @php $permissions=session('admin_permissions') @endphp
    @if(in_array('admins',$permissions))
    <p class="btn btn-secondary link_to_page" data-url="{{route('admins.index')}}" >admins: {{$number_of_admins}}</p>
    @endif
    @if(in_array('roles',$permissions))
    <p class="btn btn-warning link_to_page" data-url="{{route('roles.index')}}" >roles: {{$number_of_roles}}</p>
    @endif
    @if(in_array('times',$permissions))
    <p class="btn btn-info link_to_page" data-url="{{route('times.index')}}" >times: {{$number_of_times}}</p>
    @endif
    @if(in_array('users',$permissions))
    <p class="btn btn-success link_to_page" data-url="{{route('users.index')}}" >users: {{$number_of_users}}</p>
    @endif
    @if(in_array('pharmacies',$permissions))
    <p class="btn btn-primary link_to_page" data-url="{{route('pharmacies.index')}}" >pharmacies: {{$number_of_pharmacies}}</p>
    @endif
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
