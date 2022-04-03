
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

<!-- search times -->
<div id="search_times" class="mt-3"> 
</div>

<!-- view user's time table -->
<div id="list_times">
</div>

<!-- edit user -->
<div id="edit_user">
</div>

<!-- list users -->
<div id="list_users">
</div>

<script>
    function renderUserList(){
        $.ajax({
            url:"{{route('getListOfUsers')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}"},
            success:function(result){
                if(result.return==1){
                    $("#list_users").html(result.html);
                }
            }
        });  
    }
    renderUserList();

    function renderSearchTime(){
        $.ajax({
            url:"{{route('getSearchTimeForm')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}"},
            success:function(result){
                if(result.return==1){
                    $("#search_times").html(result.html);
                }
            }
        });  
    }
    function renderTimeList(user_id){
        var daterange=$('#search_date').val();
        var pharmacy_name=$('#pharmacy_name').val();
        $.ajax({
            url:"{{route('getListOfTimes')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}",'pharmacy_name':pharmacy_name,'daterange':daterange,'user_id':user_id},
            success:function(result){
                if(result.return==1){
                    $("#list_times").html(result.html);
                }
            }
        });
    }
     
    
</script>

<script>
    $('#create_form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"{{route('users.create')}}",
            type:'GET',
            data:$(this).serialize(),
            success:function(result){
                $('#create_form').trigger("reset");
                renderUserList();
                renderStats();
            }
        });
    });

</script>

</div>
