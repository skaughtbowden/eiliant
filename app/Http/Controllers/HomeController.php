<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // get all locations for this user and check each one for stale or missing weather data
        $locations = $user
            ->locations()
            ->orderBy('city')
            ->orderBy('state')
            ->orderBy('zip')
            ->get();

        foreach ($locations as $location) {
            $updated = $location->updateWeather();

            if ($updated) {
                $location = $updated;
            }
        }

        return View::make('home', compact('user', 'locations'));
    }
}
