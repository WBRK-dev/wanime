<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Watchlist;
use App\Models\Star;
use App\Models\Anime;

class WatchController extends Controller
{

    public function __construct() {
        if ($_ENV["REQ_AUTH"] === "true") {
            $this->middleware('auth');
        }
    }

    function show(Request $request) {

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

        $anime = $response->json();

        try {
            $response = Http::get($_ENV["API_URL"]."/anime/episodes/".$request->query("id"));
        } catch (\Throwable $th) {
            return view("error.500");
        }

        if ($response->tooManyRequests()) {
            return view("error.429");
        }

        if ($response->failed()) {
            return view("error.500");
        }

        $episodes = $response->json();
        $epstring = $response->body();

        $history = 0;
        $watchlistLabels = ["watching" => "Watching", "planning" => "Planning", "completed" => "Completed", "paused" => "Paused", "dropped" => "Dropped"];
        $watchlist = ["label"=>"WatchList", "value"=>""];
        if (Auth::check()) {
            $items = WatchList::select("status", "episode")->where('userId', Auth::user()->id)->where('animeId', $anime["anime"]["info"]["id"])->get();
            if (count($items) > 0) {
                $watchlist["value"] = $items[0]->status;
                $watchlist["label"] = $watchlistLabels[$items[0]->status];
                $history = $items[0]->episode;
            }
        }

        $stars = Star::select(DB::raw("AVG(stars) as stars"))->where("animeId", $anime["anime"]["info"]["id"])->get()[0]->stars;

        if (Auth::check()) {
            $selectedStars = Star::select("stars")->where("animeId", $anime["anime"]["info"]["id"])->where("userId", Auth::user()->id)->get()[0]->stars ?? 0;
        }

        return view("watch.watch", [
            "anime" => $anime,
            "episodes" => $episodes,
            "epstring" => $epstring,
            "history" => $history,
            "watchlist" => $watchlist,
            "stars" => [
                "avg" => $stars,
                "selected" => $selectedStars ?? 0
            ]
        ]);
    }

    function epupdate(string $animeid, Request $request) {

        $user = Auth::user();

        if ($user->save_episode_progress === "never") {return "failed";}

        $items = Watchlist::select("*")->where('animeId', $animeid)->where('userId', $user->id)->get();
        if ($user->save_episode_progress === "in_watching" && !(count($items) > 0 && $items[0]->status === "watching")) {return "failed";}

        if ($user->save_episode_progress === "always" && count($items) === 0) {return "failed";}

        Watchlist::select("*")->where('animeId', $animeid)->where('userId', $user->id)->update(['episode' => $request->input("episode")]);

        return "success";

    }

    function star(Request $request) {

        $stars = $request->input("stars");
        $id = $request->input("id");
        $userId = Auth::user()->id;

        if ($stars <= 0 || $stars > 5) return response()->json(["error"=>true, "Wrong amount of stars."]);

        if (Star::where("userId", $userId)->where("animeId", $id)->count() > 0) {
            Star::where("userId", $userId)->where("animeId", $id)->update(["stars" => $stars]);
        } else {
            Star::insert([
                "userId" => $userId,
                "stars" => $stars,
                "animeId" => $id
            ]);
        }
        
        if (Anime::where('animeId', $id)->count() === 0)  {
            Anime::insert([
                "animeId" => $id,
                "title" => $request->input("title"),
                "image" => $request->input("poster")
            ]);
        }

        $stars = Star::select(DB::raw("AVG(stars) as stars"))->where("animeId", $id)->get()[0]->stars;

        return response()->json([
            "stars" => $stars
        ]);
    }
}