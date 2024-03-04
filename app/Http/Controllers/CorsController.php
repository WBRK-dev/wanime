<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CorsController extends Controller
{
    function cors(Request $request) {
        $response = Http::get($request->input("url"));


        return response($response->body())->header("Content-Type", "text/vtt");
    }
}
