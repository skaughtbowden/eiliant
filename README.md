# Eiliant

A Laravel demonstration project with the following goals:

* app should require a user to sign in 
* prompt a user’s location 
* retrieve weather data from API
* displays the current weather info about the location
* user should be able to setup multiple locations to check weather   
* when the app updates the weather info, it should update each location
* users and their locations should be stored in a database

---
**Eiliant** was written in PHP using the [Laravel](http://laravel.com) framework, 
primarily because I have the most familiarity with it, and wanted to get a demo
deployed rapidly. (Rapid development is *kind of* Laravel's whole thing.)

For my weather data source, I selected [Dark Sky](http://darksky.net) based on its 
ease-of-use, and availability for limited free usage. Originally, I was going to use 
[OpenWeatherMap](https://openweathermap.org/), which is also free and allows batch downloads
with a single API call, but eventually I  decided I would prefer to use publicly available 
latitude/longitude pairs I found
on [GasLampMedia](https://www.gaslampmedia.com/download-zip-code-latitude-longitude-city-state-county-csv/)
rather than OWM's ID-based calls.
DarkSky also offered a wide range of additional features that I may implement in the future,
just for fun.

Because this demo uses Dark Sky's free developer plan, it is limited to 1000 API calls per month.
Eiliant pages do not automatically check for updates on a Javascript timer, but each time the page is
reloaded a check **is** made to see when every location in a user's list was last cached; if
it is more than 30 minutes stale, new data is retrieved.

Additionally, because this project is deployed to a free Heroku plan at [eiliant.herokuapp.com](http://eiliant.herokuapp.com),
it is limited to 10,000 rows in the database. The locations table alone contained over 42,000 U.S. 
towns and cities, and may be truncated down to a single state's data sometime shortly after 4/26/2017.

---

Usage:
1. Register with your name and email address
    * If you've already registered, then just log in!
2. Enter the name or zip code of a town or city
    * To specify a state, use "city, state" format
3. Select the matching location from the list presented
4. Enjoy knowing what the weather is like in that place!

**NOTE:** There is a limit of 20 locations stored per-user.
You can click the Delete icon to the right of each saved
location to make room for new, more interesting locations.

![](http://eiliant.herokuapp.com/images/eiliant.png)

*developed by [Skaught Bowden](http://www.linkedin.com/in/skaughtbowden/), GitHub [http://github.com/skaughtbowden](http://github.com/skaughtbowden)*

---

*eiliant* – Sindarin (Elvish, J.R.R. Tolkien), 
n. ( **eilianw** , **eilian** ) *n.* rainbow, 
lit. 'sky-bridge', related **ninniach*** *n.*