<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Watchlist;
use App\Models\Star;

class HomeController extends Controller
{
    function home() {

        $history = [];
        if (Auth::check()) {
            $user = Auth::user();
            $history = $user->watchlistItems->where("status", "watching")->take(10);
        } else {$user = false;}

        try {
            $response = Http::get($_ENV["API_URL"]."/anime/home/");
        } catch (\Throwable $th) {
            return view("error.500");
        }

        if ($response->tooManyRequests()) {
            return view("error.429");
        }

        if ($response->failed()) {
            return view("error.500");
        }

        $response = $response->json();

        $reviews = Star::orderBy("created_at", "desc")->limit(10)->get();

        return view("home", [
            "user" => $user,
            "history" => $history,
            "spotlight" => $response["spotlightAnimes"],
            "trending" => $response["trendingAnimes"],
            "latest" => $response["latestEpisodeAnimes"],
            "popular" => $response["top10Animes"]["month"],
            "reviews" => $reviews
        ]);
    }
}
