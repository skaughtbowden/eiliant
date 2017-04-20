<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;

class SearchController extends Controller
{
    // Search Locations table by submitted city name

    public function locations(Request $request) {
        $locations = Location::where('city', 'ILIKE', '%' . $request->term . '%')
            ->orWhere('zip', 'LIKE', $request . '%')
            ->get();

        $results = array();

        foreach ($locations as $location) {
            $results[] = ['id' => $location->id, 'city' => $location->city, 'state' => $location->state];
        }

        return response()->json($results);
    }

}
