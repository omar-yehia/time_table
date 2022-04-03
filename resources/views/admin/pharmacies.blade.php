@php $permissions=session('admin_permissions') @endphp
@if(in_array('pharmacies',$permissions))
<div id="body" class="container">

<!-- create pharmacy -->
<h3 class="mt-3">Create Pharmacy</h3>
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


<!-- search times -->
<div id="search_times" class="mt-3"> 
</div>

<!-- view pharmacy's time table -->
<div id="list_times">
</div>

<!-- edit pharmacy -->
<div id="edit_pharmacy">
</div>

<!-- list pharmacies -->
<div id="list_pharmacies">
</div>


<script>
    function renderPharmacyList(){
        $.ajax({
            url:"{{route('getListOfPharmacies')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}"},
            success:function(result){
                if(result.return==1){
                    $("#list_pharmacies").html(result.html);
                }
            }
        });  
    }
    renderPharmacyList();
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
    function renderTimeList(owner_user_id=0,owner_pharmacy_id=0){
        var daterange=$('#search_date').val();
        var pharmacy_name=$('#pharmacy_name').val();
        $.ajax({
            url:"{{route('getListOfTimes')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}",'pharmacy_name':pharmacy_name,'daterange':daterange,'pharmacy_id':owner_pharmacy_id},
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
            url:"{{route('pharmacies.create')}}",
            type:'GET',
            data:$(this).serialize(),
            success:function(result){
                $('#create_form').trigger("reset");
                renderPharmacyList();
                renderStats();
            }
        });
    });

</script>

</div>
@endif