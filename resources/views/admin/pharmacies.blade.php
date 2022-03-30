@extends('layout')
@section('title','Pharmacies')

@section('body')
<div id="body" class="container">

@if(Session::has('success'))
    <p class="alert-success">{{Session::get('success')}}</p>
@elseif(Session::has('error'))
    <p class="alert-danger">{{Session::get('error')}}</p>
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

    <table>
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
                $("body").html(result);
            }
        });
    });
</script>
    
</div>

@endsection