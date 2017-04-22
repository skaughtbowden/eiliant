@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Welcome, {{ $user->name }}!
                    </h3>
                </div>

                <div class="panel-body">
                    Add a location to your weather tracker:
                    <input type="text" placeholder="city name or zip code" id="location" name="location">
                </div>
            </div>

                <div class="alert alert-danger" id="error_container" style="display: none;">
                    <ul>
                        <li id="error"></li>
                    </ul>
                </div>

            @if($locations->count() > 0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title pull-left">Weather information for your locations</div>
                    <div class="pull-right"><span id="location_count">{{ $user->locations()->count() }}</span> / 20 Locations Saved</div>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body" id="locations">
                    @include('partials.locations')
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script type="text/javascript">
    $('#location').autocomplete({
        source:'http://localhost:8000/api/search',
        minlength: 3,
        delay: 500,
        autoFocus: true,
        select: function(e, ui) {
            $.post(
                '{{ url('/api/location') }}',
                { location_id: ui.item.id, user_id: {{$user->id}} },
                function(data) { // SUCCESS
                    // write in template rendering provided by controller
                    $('#locations_list').replaceWith(data);

                    // re-bind events to replacement HTML
                    // ??????

                    // delete text from input
                    $('#location').val('');

                    // increment counter
                    $("#location_count").html(parseInt($("#location_count").html(), 10) + 1);
                }
            )
            .fail(function(xhr) {
                $("#error").text(JSON.parse(xhr.responseText));
                $("#error_container").show();
            })
        }
    });

    $(document).on('click', '.deleteLocation', function(e) {
        var $tr = $(this).closest('tr');

        if(confirm('Are you sure to delete this location?')) {
            $.ajax({
                url: '{{ url('/api/location') }}' + '/' + {{$user->id}} + '/' + $(this).attr('data-id'),
                type: 'post',
                data: { _method: 'delete' },
                success: function(response) {
                    // decrement counter
                    $("#location_count").html(parseInt($("#location_count").html(), 10) - 1);

                    // deletion successful, remove the parent row
                    $tr.find('td').fadeOut(1000,function(){
                        $tr.remove();
                    });
                },
                error:function (xhr, ajaxOptions, thrownError){
                    alert(thrownError);
                }
            });
            return false;
        }
    });

</script>
@endsection
