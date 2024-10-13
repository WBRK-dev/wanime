<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AnimeController extends Controller
{
    function show(Request $request) {

        $anime = AniwatchApiController::innerExecute(config("aniwatchapi.routes.about"). "?id=" . $request->input("id"));

        if (Auth::check()) $watchlistStatus = Watchlist::where("animeId", $request->input("id"))->where("userId", Auth()->user()->id)->first()?->status;

        return Inertia::render("About/Index", [
            "anime" => $anime["anime"],
            "watchlistStatus" => $watchlistStatus ?? null,
            "seasons" => $anime["seasons"],
            "relatedAnime" => $anime["relatedAnimes"],
            "recommendedAnime" => $anime["recommendedAnimes"],
            "routes" => [
                "anime-show" => route("anime.show"),
                "anime-watch" => route("anime.watch"),
                "anime-update-watchlist" => route("api.anime.watchlist.put", ["animeId" => $request->input("id")])
            ]
        ]);
    }

    function watch(Request $request) {

        $anime = AniwatchApiController::innerExecute(config("aniwatchapi.routes.about"). "?id=" . $request->input("id"));
        $animeEpisodes = AniwatchApiController::innerExecute(config("aniwatchapi.routes.episodes"). "/" . $request->input("id"));

        $watchlist = null;
        if (Auth::check()) $watchlist = Watchlist::where("animeId", $request->input("id"))->where("userId", Auth()->user()->id)->first();

        return Inertia::render("Watch/Index", [
            "anime" => $anime["anime"],
            "episodes" => $animeEpisodes["episodes"] ?? null,
            "watchlistStatus" => $watchlist?->status ?? null,
            "seasons" => $anime["seasons"],
            "relatedAnime" => $anime["relatedAnimes"],
            "recommendedAnime" => $anime["recommendedAnimes"],
            "apiUrl" => config("aniwatchapi.frontend_url"),
            "selectedEpisodeIndex" => $watchlist?->episode ?? 0,
            "routes" => [
                "anime-update-episode" => route("api.anime.episode.put", ["animeId" => $request->input("id")]),
            ]
        ]);

    }

    function updateWatchlistStatus(Request $request, String $animeId) {
        $allowedStatus = ["watching", "planning", "completed", "paused", "dropped", "remove"];
        $status = $request->input("status");
        $user = Auth::user();

        if (!in_array($status, $allowedStatus)) abort(400);

        if ($status === "remove") {
            Watchlist::where("animeId", $animeId)->where("userId", $user->id)->delete();
            return "success";
        }

        $watchlist = Watchlist::where("animeId", $animeId)->where("userId", $user->id)->first();

        if ($watchlist) {
            $watchlist->status = $request->input("status");
            $watchlist->save();
        } else {
            Watchlist::create([
                "animeId" => $animeId,
                "userId" => $user->id,
                "status" => $request->input("status"),
                "episode" => 0
            ]);
        }

        Anime::updateOrCreate(["animeId" => $animeId], [
            "animeId" => $animeId,
            "title" => $request->input("anime.title"),
            "image" => $request->input("anime.image"),
        ]);

        return "success";
    }

    function updateWatchlistEpisode(Request $request, String $animeId) {
        $user = Auth::user();
        $watchlist = Watchlist::where("animeId", $animeId)->where("userId", $user->id)->first();

        if (!$watchlist) abort(400);

        $watchlist->episode = $request->input("episode");
        $watchlist->save();

        return "success";
    }
}
