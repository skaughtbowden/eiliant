<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;

class SearchController extends Controller
{
    // Search Locations table by submitted city name

    public function locations(Request $request) {

        $q = $request->term;

        if ( strpos($q, ',') !== false){

            // search by city and state
            $loc_array = array_map('trim', explode(',', $q));
            $city = $loc_array[0];
            $state = $loc_array[1];
            $locations = Location::where('city', 'ILIKE', '%' . $city . '%')
                ->where('state', 'ILIKE', $state)
                ->orderBy('city','state','zip')
                ->get();
        } elseif (is_numeric($q)) {
            // search by zip code
            $locations = Location::where('zip', 'LIKE', $q . '%')
                ->orderBy('city','state','zip')
                ->get();
        } else {
            // search just by city name
            $locations = Location::where('city', 'ILIKE', '%' . $q . '%')
                ->orderBy('city','state','zip')
                ->get();
        }

        $results = array();

        foreach ($locations as $location) {
            $results[] = [
                'label' => $location->city . ', ' . $location->state . ' ' . $location->zip,
                'id' => $location->id
            ];
        }

        return response()->json($results);
    }

}
