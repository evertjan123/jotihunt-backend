<?php

namespace App\Http\Controllers;

use App\Models\Hunters;
use App\Models\Hunts;
use Illuminate\Http\Request;

class HuntsController extends Controller
{
    public function get(Request $request) {
        $hunters = Hunts::with( 'hunters')->with('area')->orderBy('created_at', 'desc')->get()->toArray();

        return response()->json(['data' => $hunters]);
    }

    public function post(Request $request, $id) {
        $code = $request->input('code');
        $area_id = $request->input('area_id');

        if (!$area_id || !$code || !$id) {
            return response()->json(['error' => 'no code, area or user found'], 400);
        } else {
            $hunt = Hunts::create([
                'code' => $code,
                'area_id' => $area_id,
                'hunter_id' => $id,
            ]);;

            $hunt->save();

            return response()->json(['success' =>true, 'data' => $hunt]);
        }
    }
}
