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

    public function download(Request $request, $id) {
        $secret = $request->query('secret');
        $path = Hunts::find($id)->path_to_file;
        if($secret !== 'HeerlijkeHathi') {
            return response()->json(['nothing here' => true], 404);
        }

        $filename = str_replace('images/', '', $path);

        $path = storage_path('app/images/' . $filename); // Adjust the path as needed

        if (!Storage::exists('images/' . $filename)) {
            abort(404);
        }

        return response()->download($path, $filename);
    }

    public function post(Request $request, $id) {
        $code = $request->input('code');
        $time = $request->input('time');
        $area_id = $request->input('area_id');

        if (!$area_id || !$code || !$time || !$id) {
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
