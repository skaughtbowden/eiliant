<table class="table table-striped table-hover table-condensed" id="locations_list">
    <thead>
        <tr>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Current</th>
            <th>High</th>
            <th>Low</th>
            <th>Precip</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @forelse ($locations as $location)
        <tr>
            <td>{{ $location->city }}</td>
            <td>{{ $location->state }}</td>
            <td>{{ $location->zip }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">
                <div title="Delete">
                    <button class="btn btn-danger btn-xs deleteLocation" data-id="{{ $location->id }}">
                        <span class="glyphicon glyphicon-trash"></span>
                    </button>
                </div>
            </td>
        </tr>
    @empty
        <tr>
            <td>no locations!</td>
        </tr>
    @endforelse
    </tbody>
</table>