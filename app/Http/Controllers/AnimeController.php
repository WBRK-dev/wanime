<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Watchlist;
use App\Models\Star;

class AnimeController extends Controller
{
    function home(Request $request) {

        try {
            $response = Http::get($_ENV["API_URL"]."/anime/info?id=".$request->query("id"));
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

        $watchlistLabels = ["watching" => "Watching", "planning" => "Planning", "completed" => "Completed", "paused" => "Paused", "dropped" => "Dropped"];
        $watchlist = ["label"=>"WatchList", "value"=>""];
        if (Auth::check()) {
            $items = WatchList::select("status")->where('userId', Auth::user()->id)->where('animeId', $results["anime"]["info"]["id"])->get();
            if (count($items) > 0) {
                $watchlist["value"] = $items[0]->status;
                $watchlist["label"] = $watchlistLabels[$items[0]->status];
            }
        }

        $stars = Star::select(DB::raw("AVG(stars) as stars"))->where("animeId", $results["anime"]["info"]["id"])->get()[0]->stars;

        return view("anime", [
            "results" => $results,
            "watchlist" => $watchlist,
            "stars" => floatval($stars ?? 0)
        ]);
    }
}