<?php

use App\Http\Controllers\AnimeController;
use Illuminate\Support\Facades\Route;

Route::put("/watchlist/{animeId}", [AnimeController::class, "updateWatchlistStatus"]);