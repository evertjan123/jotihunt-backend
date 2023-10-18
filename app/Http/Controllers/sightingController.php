<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sighting;


class sightingController extends Controller
{
    public function get(Request $request) {
        $alpha = sighting::with('area')->with('hunters')->where('area_id', 1)->orderBy('created_at', 'DESC')->get()->take(6);
        $beta =  sighting::with('area')->with('hunters')->where('area_id', 2)->orderBy('created_at', 'DESC')->get()->take(6);
        $charlie = sighting::with('area')->with('hunters')->where('area_id', 3)->orderBy('created_at', 'DESC')->get()->take(6);
        $echo =  sighting::with('area')->with('hunters')->where('area_id', 4)->orderBy('created_at', 'DESC')->get()->take(6);
        $delta =  sighting::with('area')->with('hunters')->where('area_id', 5)->orderBy('created_at', 'DESC')->get()->take(6);
        $foxtrot =  sighting::with('area')->with('hunters')->where('area_id', 6)->orderBy('created_at', 'DESC')->get()->take(6);
        return ["data" => array_merge(json_decode($alpha, true), json_decode($beta, true),json_decode($charlie, true),json_decode($echo, true),json_decode($delta, true),json_decode($foxtrot, true))];    
    }

    public function getById(Request $request) {
        return ['data' => sighting::with('area')->with('hunters')->where('area_id',$request->route('id'))->get()];
    }

    public function delete(Request $request) {
        return ['data' => sighting::where('id',$request->route('id'))->delete()];
    }

    public function post(Request $request) {
        $body = json_decode($request->getContent());
        try { 
            
            $sighting = sighting::create([
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
    }
}
