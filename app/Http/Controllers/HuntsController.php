<?php

namespace App\Http\Controllers;

use App\Models\Hunter;
use App\Models\Hunts;
use Illuminate\Http\Request;

class HuntsController extends Controller
{
    public function get(Request $request) {
        $hunters = Hunts::with( 'hunter')->with('area')->orderBy('created_at', 'desc')->get()->toArray();

        return response()->json(['data' => $hunters]);
    }

    public function post(Request $request, $id) {
        $code = $request->input('code');
        $time = $request->input('time');
        $area_id = $request->input('area_id');

        if (!$area_id || !$code || $time || !$id) {
            return response()->json(['error' => 'no code, area or user found'], 400);
        } else {
            $path = null;
            if($request->file('image')){
                $path = $request->file('image')->store('images');
            }

            $hunt = Hunts::create([
                'code' => $code,
                'area_id' => $area_id,
                'time' => $time,
                'path_to_photo' => $path,
                'hunter_id' => $id,
            ]);;

            $hunt->save();

            return response()->json(['success' =>true, 'data' => $hunt]);
        }
    }
}
