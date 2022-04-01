
<div id="body" class="container">

 

<h3>Create User</h3>
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

<div class="mt-5" id="list_user_time_table">
</div>

<h3 class="mt-5">List of users</h3>
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
                <button class="view btn btn-info" data-id="{{$user->id}}">view time table</button>
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
                if(result.return==1){
                    var number=$('#number_of_users').data('number');
                    $('#number_of_users').text(++number);
                    $("#admin_app_container").html(result.html);
                }
            }
        });
    });
</script>
<script>
    $('.view').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('view_user_times')}}",
            type:'GET',
            data:{id:id},
            success:function(result){
                $("#list_user_time_table").html(result);
            }
        });
    });
    
</script>
<script>
    setTimeout(function() {
      $('#success').fadeOut('slow');
    }, 2000);
    setTimeout(function() {
      $('#error').fadeOut('slow');
    }, 2000);
</script>

</div>
