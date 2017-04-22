<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function city_state() {
        return $this->city . ', ' . $this->state . ' [' . $this->zip . ']';
    }

    public function updateWeather() {

        // only hit API for a given location once every 30 minutes
        $now = time();
        $key = config('services.dark_sky.key');
        $exclusions = '?exclude=minutely,hourly,alerts,flags';

        // https://api.darksky.net/forecast/[key]/[latitude],[longitude]
        $url = "https://api.darksky.net/forecast/" . $key . '/';

        if ($this->weather) {
            if (round(abs($now - $this->last_weather_check) / 60,2) <= 30) {
                // serve up the cached weather
                return false;
            }
        }
        // weather is either empty or old
        // fetch new weather data & save to this location
        $latlong = strval($this->latitude) . ',' . strval($this->longitude);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url . $latlong . $exclusions,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
        ));

        $new_weather = curl_exec($curl);
        $err = curl_error($curl);

        if (!$err) {
            $this->weather = $new_weather;
            $this->last_weather_check = $now;
            $this->save();
        }

        curl_close($curl);

        return $this; // send back the entire object
    }

}
