<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SerpController extends Controller
{
    public function index(){
        return view('index');
    }
    public function search(Request $request){
        $keyword = $request->input('keyword');
        $domain = $request->input('domain');
        $location = $request->input('location_code', 2840);
        $language = $request->input('language_code', 'en');

        return response()->json([
            'status' => 'success',
            'message' => 'Роут працює, дані отримано!',
            'data' => [
                'keyword' => $keyword,
                'domain' => $domain
            ]
        ]);
    }
}
