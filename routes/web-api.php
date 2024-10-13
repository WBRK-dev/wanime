<?php

use App\Http\Controllers\AnimeController;
use Illuminate\Support\Facades\Route;

Route::put("/watchlist/{animeId}", [AnimeController::class, "updateWatchlistStatus"])->middleware("auth")->name("api.anime.watchlist.put");
Route::put("/watchlist/{animeId}/episode", [AnimeController::class, "updateWatchlistEpisode"])->middleware("auth")->name("api.anime.episode.put");
