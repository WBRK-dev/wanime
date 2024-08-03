<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AniwatchApiController extends Controller
{
    function execute(Request $request) {
        $response = Http::get(config("aniwatchapi.url") . $request->input("url"));
        return response($response->json())->withStatus($response->getStatusCode());
    }

    static function innerExecute($url) {
        $response = Http::get(config("aniwatchapi.url") . $url);
        $statusCode = $response->getStatusCode();
        if ($statusCode < 200 || $statusCode >= 300) {
            abort(500);
        }

        return $response->json();
    }
}
