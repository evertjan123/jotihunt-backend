<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Clubhouse;
use App\Models\Area;
use App\Models\Article;
use App\Models\Sighting;
use App\Models\Hunters;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/homes', function (Request $request) {
    return ['data' => ClubHouse::all()];
});

Route::get('/areas', function (Request $request) {
    return ['data' => Area::all()];
});

Route::get('/articles', function (Request $request) {
    return ['data' => Article::all()];
});


/**
 * HUNTERS
 */
Route::get('/hunters', function (Request $request) {
    return ['data' => Hunters::all()];
});

Route::post('/hunter', function (Request $request) {
    $body = json_decode($request->getContent());
    try { 
        
        $Hunter = Hunters::create([
            'driver' => $body->driver,
            'license_plate' => $body->license_plate,
            'lat' => $body->long ?? null,
            'long' => $body->lat ?? null,
            'location_send_at' => $body->location_send_at ?? null,
            'is_hunting' => true,
            'is_live' =>  $body->is_live
        ]);
        
        $Hunter->save();

        return ['success' =>true, 'data' => $Hunter];

    } catch(Error $e) {
        return ['success' =>false, 'error' => $e];
    }
});

Route::post('/hunter/update/{id}', function (Request $request) {
    $body = json_decode($request->getContent());
    $id = $request->route('id');
    try { 
        $Hunter = Hunters::find($id);
        if($Hunter){
            foreach(json_decode($request->getContent()) AS $key => $value){
                $Hunter->{$key} = $value;
                // Example: $key = "username", $value = "BobSmith"; `$user->username = "BobSmith";`
            }

            $Hunter->save();

            return ['success' =>true, 'data' => $Hunter];
        } else {
            return ['success' =>false, 'error' => "no hunter found"];

        }
    } catch(Error $e) {
        return ['success' =>false, 'error' => $e];
    }
});



/**
 * SIGHTINGS
 */
Route::get('/sightings', function (Request $request) {
    return ['data' => Sighting::with('area')->with('hunters')->get()];
});

Route::get('/sightings/{id}', function (Request $request) {
    return ['data' => Sighting::with('area')->with('hunters')->where('area_id',$request->route('id'))->get()];
});

Route::post('/sighting', function (Request $request) {
    $body = json_decode($request->getContent());
    try { 
        
        $sighting = Sighting::create([
            'description' => $body->description ?? null,
            'lat' => $body->lat,
            'long' => $body->long,
            'optional_name' => $body->optional_name ?? null,
            'hunter_id' => $body->hunter_id ?? null,
            'area_id' => $body->area_id,
        ]);
        
        $sighting->save();

        return ['success' =>true, 'data' => $sighting];

    } catch(Error $e) {
        return ['success' =>false, 'error' => $e];
    }
});
