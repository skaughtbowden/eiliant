<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();
        return $locations;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Creates a new record in location_user
        $user = User::find($request->user_id);

        if ( $user->locations()->count() >= 20 ) {
            // maximum location storage reached
            // return an error
            $code = 500;
            $error = "You have exceeded your maximum location storage.";

            return response()->json($error, $code);
        }

        $location = Location::find($request->location_id);
        // Check if current user already has this location associated
        if ( $user->locations()->find($request->location_id) ) {
            // already have this location saved
            $code = 500;
            $error = "You already have this location in your list.";

            return response()->json($error, $code);
        }

        $user->locations()->save($location);

        $locations = $user
            ->locations()
            ->orderBy('city')
            ->orderBy('state')
            ->orderBy('zip')
            ->get();

        return view('partials.locations', compact('locations'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = Location::find($id);
        return $location;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $locationId)
    {
        //
    }

    public function customDestroy($userId, $locationId)
    {
        $user = User::find($userId);
        $location = $user->locations()->find($locationId);

        if ( $location ) {
            $user->locations()->detach($location);
            return response(['msg' => 'Location deleted.', 'status' => 'success']);
        }
        return response(['msg' => 'Failed deleting the location', 'status' => 'failed']);
    }
}
