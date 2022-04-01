
<div id="body" class="container">

@if(session('success'))
    <p id="success" class="alert alert-success">{{session('success')}}</p>
@elseif(session('error'))
    <p id="error" class="alert alert-danger">{{session('error')}}</p>
@endif

<!-- create pharmacy -->
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

    <!-- list pharmacies -->
    <div class="text-success">

    <table class="table table-striped">
        <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">name</th>
        <th scope="col">actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($allPharmacies as $pharmacy)
        <tr>
        <th scope="row">{{1+$loop->index}}</th>
            <td>{{$pharmacy->name}}</td>
            <td>
                <button class="edit btn btn-info">edit</button>
                <button class="view btn btn-info">view time table</button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    $('#create_form').on('submit',function(e){
        e.preventDefault();
        $.ajax({
            url:"{{route('pharmacies.create')}}",
            type:'GET',
            data:$(this).serialize(),
            success:function(result){
                var number=$('#number_of_pharmacies').data('number');
                $('#number_of_pharmacies').text(++number);
                $("#admin_app_container").html(result);
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