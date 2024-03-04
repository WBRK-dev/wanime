<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    function home(Request $request) {

        try {
            $response = Http::get($_ENV["API_URL"]."/anime/search?q=". $request->query("search") ."&page=" . $request->query("page") ?? 1);
        } catch (\Throwable $th) {
            return view("error.500");
        }

        if ($response->tooManyRequests()) {
            return view("error.429");
        }

        if ($response->failed()) {
            return view("error.500");
        }

        $results = $response->json();

        // dd($results);

        return view("search", [
            "results" => $results
        ]);
    }
}
