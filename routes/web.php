<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\UserController;

require __DIR__.'/auth.php';

// API Routes
Route::prefix("api")->group(function() { include_once __DIR__ . "/web-api.php"; });

// Web Routes
Route::get("/", [HomeController::class, "show"])->name("home");

Route::get("/anime", [AnimeController::class, "show"]);

Route::get("/watch", [AnimeController::class, "watch"]);

Route::inertia("/login", "Login/Index");

Route::get("/user/{user}/watchlist", [UserController::class, "showWatchlist"]);