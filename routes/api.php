<?php

use App\Http\Controllers\HuntsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Clubhouse;
use App\Models\Area;
use App\Models\Article;
use App\Models\sighting;
use App\Models\Hunter;

use App\Http\Controllers\sightingController;
use App\Http\Controllers\hunterController;


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
Route::get('/hunters', [hunterController::class, 'get']);

Route::post('/hunter', [hunterController::class, 'create']);

Route::post('/hunter/login', [hunterController::class, 'login']);

Route::delete('/hunter/{id}', [hunterController::class, 'delete']);

Route::patch('/hunter/{id}/update/location', [hunterController::class, 'updateLocation'])->middleware('auth:api');;

Route::patch('/hunter/{id}/update/status', [hunterController::class, 'updateStatus'])->middleware('auth:api');;

/**
 * SIGHTINGS
 */
Route::get('/sightings', [sightingController::class, 'get']);

Route::get('/sightings/{id}', [sightingController::class, 'getById']);

Route::delete('/sightings/{id}', [sightingController::class, 'delete']);

Route::post('/sighting', [sightingController::class, 'post'])->middleware('auth:api');

/**
 * HUNTS
 */
Route::get('/hunts', [HuntsController::class, 'get']);

Route::post('/hunts/{id}', [HuntsController::class, 'post'])->middleware('auth:api');



/**
 * CRON JOBS
 */

Route::get('/cron/clubhouses', function (Request $request) {
    return Artisan::call('get:clubHouses');
});

Route::get('/cron/articles', function (Request $request) {
    return Artisan::call('get:Articles');
});

Route::get('/cron/areas', function (Request $request) {
    return Artisan::call('get:Areas');
});
