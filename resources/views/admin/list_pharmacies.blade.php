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
        @foreach($pharmacies as $pharmacy)
        <tr>
        <th scope="row">{{1+$loop->index}}</th>
            <td>{{$pharmacy->name}}</td>
            <td>
                <button data-id="{{$pharmacy->id}}" class="edit btn btn-info">edit</button>
                <button data-id="{{$pharmacy->id}}" class="view btn btn-primary">view time table</button>
                <button data-id="{{$pharmacy->id}}" class="delete btn btn-danger">delete</button>

            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    $('.delete').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('deletePharmacy')}}",
            type:'post',
            data: {'_token':"{{csrf_token()}}",'id':id},
            success:function(result){
                renderPharmacyList();
                renderStats();
            }
        });
    });
    // show edit pharmacy form
    $('.edit').on('click',function(){
        var id=$(this).data('id');
        $.ajax({
            url:"{{route('editPharmacy')}}",
            type:'GET',
            data:{id:id},
            success:function(result){
                if(result.return==1){
                    $("#edit_pharmacy").html(result.html);
                    scrollToElement('edit_pharmacy');
                    eventListenerForUpdatePharmacy();
                }else{
                    showError(result.html);
                }
            }
        });
    });
    function eventListenerForUpdatePharmacy(){
        //submit edit pharmacy form
        $('#edit_pharmacy_form').on('submit',function(e){
            e.preventDefault();
            var thisForm=$(this);
            $.ajax({
                url:"{{route('updatePharmacy')}}",
                type:'POST',
                data:$(this).serialize(),
                success:function(result){
                    if(result.return==1){
                        thisForm.remove();
                        renderPharmacyList();
                        renderStats();
                    }else{
                        showError(result.html);
                    }
                }
            });
        });        
    }

</script>
 