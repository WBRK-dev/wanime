<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use App\Models\Anime;
use App\Models\Watchlist;

class WatchListController extends Controller
{
    function main(Request $request) {

        $app = $request->input("app") ?? "watching";

        $allowedApps = ["completed", "planning", "watching", "paused", "dropped"];
        if (!in_array($app, $allowedApps)) {return view("error.500");}

        // $anime = Watchlist::select("*")->join("anime", "watchlists.animeId", "=", "anime.animeId")->where('watchlists.userId', Auth::user()->id)->where('watchlists.status', $app)->orderBy('watchlists.updated_at', 'desc')->get();
        $anime = Auth::user()->watchlistItems->where("status", $app);

        return view("watchlist", [
            "anime" => $anime
        ]);
    }

    function update(string $animeid, Request $request) {

        $user = Auth::user();
        $status = $request->input("status");
        if (!isset($status)) {return "failed";}

        $statusses = ["watching", "planning", "completed", "paused", "dropped", "remove"];

        if (!in_array($status, $statusses)) {return "failed";}

        if ($status === "remove") {

            Watchlist::where('userId', $user->id)->where('animeId', $animeid)->delete();

            return "success";

        }

        if (count(Watchlist::select("*")->where('userId', $user->id)->where('animeId', $animeid)->get()) > 0) {
            Watchlist::where('userId', $user->id)->where('animeId', $animeid)->update(['status' => $request->input("status")]);
        } else {
            Watchlist::insert([
                "userId" => $user->id,
                "animeId" => $animeid,
                "status" => $request->input("status"),
                "episode" => 0
            ]);
        }

        if (Anime::select("*")->where('animeId', $animeid)->count() === 0)  {
            Anime::insert([
                "animeId" => $animeid,
                "title" => $request->input("anime")["title"],
                "image" => $request->input("anime")["image"]
            ]);
        }

        return "success";

    } 
}