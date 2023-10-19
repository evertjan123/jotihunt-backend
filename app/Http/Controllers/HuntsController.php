<?php

namespace App\Http\Controllers;

use App\Models\Hunters;
use App\Models\Hunts;
use Illuminate\Http\Request;

class HuntsController extends Controller
{
    public function get(Request $request) {
        $hunters = Hunts::with(['area', 'hunters'])->orderBy('created_at', 'desc')->get()->toArray();

        return response()->json(['data' => $hunters]);
    }

    public function post(Request $request, $id) {
        $code = $request->input('code');
        $area_id = $request->input('area_id');

        $hunter = Hunters::find($id);
        if (!$area_id || !$code || !$hunter) {
            return response()->json(['error' => 'no code, area or user found'], 400);
        } else {
            $hunt = Hunts::create([
                'code' => $code,
                'area_id' => $area_id,
                'hunter_id' => $hunter->id,
            ]);;

            $hunt->save();

            return response()->json(['success' =>true, 'data' => $hunt]);
        }
    }
}
