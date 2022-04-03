@extends('layout')
@section('title','Users')

@section('body')
<div id="body" class="container">
 
<div id="error" class="alert alert-danger" style="display:none;"></div>
<!-- stats -->
<div id="stats" class="row">

</div>
<div class="row">
    <div id="admin_app_container" class="col-md-12 p-2">
        Welcome back!
    </div>
</div>

<script>
    function showError(message){
        $('#error').html(message);
        $("#error").show();
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#error").offset().top
        }, 200);
        setTimeout(function() {
            $('#error').fadeOut('slow');
        }, 5000);
    }
    
    function scrollToElement(element_id){
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#"+element_id).offset().top
        }, 200);
    }
</script>
<script>
    function renderStats(){
        $.ajax({
            url:"{{route('getStats')}}",
            type:'POST',
            data: {'_token':"{{csrf_token()}}"},
            success:function(result){
                if(result.return==1){
                    $("#stats").html(result.html);
                }
            }
        });  
    }
    renderStats();
</script>

    
</div>

@endsection