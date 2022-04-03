
<!-- search in times -->
<h3 class="mt-3">Search</h3>
<form id="search_form">
    {{csrf_field()}}
    <input id="pharmacy_name" class="form-control" type="text" name="pharmacy_name" placeholder="pharmacy_name">
    <label for="search_date">Date</label>
    <input id="search_date" type="text" name="daterange"/>
    <button class="btn btn-primary">Search</button>
</form>
<button id="reset" class="btn btn-info">Reset</button>



<!-- search and reset -->
<script>
    $(function() {
        $('#search_date').daterangepicker({
            opens: 'left',
            minDate: new Date(),
            "locale": {
                "format": "YYYY-MM-DD",   
            }
        });
    });
    $('#reset').on('click',function(){
        $('#pharmacy_name').val('');
        $('#search_date').val('');
        renderTimeList();
    });
    $('#search_form').on('submit',function(e){
        e.preventDefault();
        renderTimeList();
    });  
    
    $(document).ready(function(){
        $('#search_date').val('');
    });
</script>