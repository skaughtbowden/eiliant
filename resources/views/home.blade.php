@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome, {{ Auth::user()->name }}!</div>

                <div class="panel-body">
                    Add a location to your weather tracker:
                    <input type="text" class="form-control" placeholder="city name or zip code" id="searchlocation" name="CityName">
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#searchlocation').autocomplete({
        source:'http://localhost:8000/api/search',
        minlength: 3,
        autoFocus: true,
        select: function(e, ui)
        {
            $('#searchlocation').val(ui.item.value);
        }
    });
</script>
@endsection
