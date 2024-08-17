<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    function showWatchlist(User $user, Request $request) {
        $selectedStatus = $request->input("status") ?? "watching";
        $allowedStatus = ["watching", "planning", "completed", "paused", "dropped"];
        if (!in_array($selectedStatus, $allowedStatus)) $selectedStatus = "watching";
        
        $watchlist = $user->watchlist()->leftJoin("anime", "watchlists.animeId", "=", "anime.animeId")
        ->select("watchlists.*", "anime.title", "anime.image")
        ->where("status", $selectedStatus)->orderBy("updated_at", "desc")
        ->paginate(16)->toArray();

        $user->totalWatchlist = $user->watchlist()->count();

        return Inertia::render("User/Watchlist/Index", [
            "animes" => $watchlist,
            "user" => $user,
            "selectedStatus" => $selectedStatus
        ]);
    }
}
