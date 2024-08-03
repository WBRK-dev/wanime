<?php

namespace App\Http\Controllers;

use App\Models\Star;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    
    public function show() {

        $anime = AniwatchApiController::innerExecute(config("aniwatchapi.routes.home"));
        $estimated = AniwatchApiController::innerExecute(config("aniwatchapi.routes.schedule")."?date=".date("Y-m-d"));
        $stars = Star::with("user", "anime")->orderBy("created_at", "desc")->limit(15)->get();

        if (Auth::check()) $watchlistAnime = Auth::user()->watchlist()->with("anime")->select("animeId", "episode")->where("status", "watching")->orderBy("updated_at", "desc")->get();

        return Inertia::render('Home/Index', [
            "watchlist" => $watchlistAnime ?? null,
            "reviews" => $stars,
            "estimatedEpisodes" => $estimated["scheduledAnimes"],
            "spotlight" => $anime["spotlightAnimes"],
            "trending" => $anime["trendingAnimes"],
            "latest" => $anime["latestEpisodeAnimes"],
            "topUpcoming" => $anime["topUpcomingAnimes"],
            "top10" => $anime["top10Animes"],
            "topAiring" => $anime["topAiringAnimes"],
            "genres" => $anime["genres"]
        ]);
    }

}
