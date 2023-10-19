<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Hunters;
use Illuminate\Support\Carbon;
use App\Models\Area;

class hunterController extends Controller
{

    public function get(Request $request) {
        $hunters = Hunters::where('is_hunting', true)->with('area')->get()->sortByDesc('location_send_at')->toArray();

        return response()->json(['data' => $hunters]);
    }

    public function updateLocation(Request $request, $id) {
        $lat = $request->input('lat');
        $long = $request->input('long');

        $hunter = Hunters::find($id);
        if (!$lat || !$long || !$hunter) {
            return response()->json(['error' => 'no lat, long or user found'], 400);
        } else {
            $hunter->lat = $lat;
            $hunter->long = $long;
            $hunter->location_send_at = Carbon::now();
            $hunter->save();

            return response()->json(['data' => $hunter]);
        }
    }

    public function updateStatus(Request $request, $id) {
        $isHunting = $request->input('is_hunting');
        $isLive = $request->input('is_live');
        $areaId = $request->input('area_id');

        $hunter = Hunters::find($id);

        if (!$hunter) {
            return response()->json(['error' => 'no user found'], 400);
        } else {
            // add new values or just use old ones
            $hunter->is_hunting = $isHunting ?? $hunter->is_hunting;
            $hunter->is_live = $isLive ??  $hunter->is_live;
            $hunter->area_id = $areaId ??  $hunter->area_id;
            $hunter->save();

            return response()->json(['data' => $hunter]);
        }
    }

    public function delete($id) {
        $hunter = Hunters::find($id);

        if (!$hunter) {
            return response()->json(['error' => 'no user found'], 400);
        } else {
            $hunter->delete();

            return response()->json(["removed" => true] , 200);
        }
    }


    public function login(Request $request) {
        $code = $request->input('code');
        $license_plate = $request->input('license_plate');

        $hunter = Hunters::where('license_plate', $request->input('license_plate'))
        ->where('code', $code)
        ->first();

        if(!$hunter){
            return response()->json(['error' => 'No hunter found'], 400);
        } else {
            $token = $hunter->createToken('Auth')->accessToken;
            return response()->json(['data' => $hunter, 'token' => $token]);
        }
    }

    public function create(Request $request) {

    if(Hunters::where('license_plate', $request->input('license_plate'))->first()){
        return response()->json(['error' => 'license plate already registered'], 400);
    }

    try {
        $Hunter = Hunters::create([
            'driver' => $request->input('driver'),
            'code' => $request->input('code'),
            'license_plate' => $request->input('license_plate'),
            'lat' => $request->input('long') ?? null,
            'long' => $request->input('lat') ?? null,
            'location_send_at' =>$request->input('location_send_at') ?? null,
            'is_hunting' => true,
            'is_live' =>  $request->input('is_live'),
            'area_id' =>$request->input('area_id')
        ]);

        $Hunter->save();

        $token = $Hunter->createToken('Auth')->accessToken;

        return response()->json(['success' =>true, 'data' => $Hunter, 'token' => $token]);

    } catch(Error $e) {
        return response()->json(['success' =>false, 'error' => $e], 401);
    }
    }
}
