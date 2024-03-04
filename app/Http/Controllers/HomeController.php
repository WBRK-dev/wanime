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
            $history = Watchlist::select("anime.title", "anime.image", "watchlists.episode", "watchlists.animeId")->join("anime", "watchlists.animeId", "=", "anime.animeId")->where('watchlists.userId', $user->id)->where('watchlists.status', 'watching')->orderBy('watchlists.updated_at', 'desc')->limit(11)->get();
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

        $reviews = Star::join('anime', 'stars.animeId', '=', 'anime.animeId')
        ->join('users', 'stars.userId', '=', 'users.id')
        ->select("stars.stars", "anime.title", "users.name", "stars.animeId", "stars.created_at")
        ->where("users.public_reviews", "=", "public")
        ->orderBy("stars.created_at", "desc")->limit(10)->get();
        
        for ($i=0; $i < count($reviews); $i++) { 
            $reviews[$i]->timeAgo = $this->time_elapsed_string($reviews[$i]->created_at);
        }

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

    function time_elapsed_string($datetime, $full = false) {
        $now = new \DateTime(date("Y-m-d"));
        $then = new \DateTime($datetime);
        $diff = $now->diff($then);

        if ($diff->y) {
            return $diff->y . " year". ($diff->y === 1 ? "" : "s") ." ago";
        } else if ($diff->m) {
            return $diff->m . " month". ($diff->m === 1 ? "" : "s") ." ago";
        } else if ($diff->d) {
            return $diff->d . " day". ($diff->d === 1 ? "" : "s") ." ago";
        } else if ($diff->h) {
            return $diff->h . " hour". ($diff->h === 1 ? "" : "s") ." ago";
        } elseif ($diff->i) {
            return $diff->i . " minute". ($diff->i === 1 ? "" : "s") ." ago";
        } else {
            return "just now";
        }
    }
}
