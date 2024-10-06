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

Route::get("/anime", [AnimeController::class, "show"])->name("anime.show");

Route::get("/watch", [AnimeController::class, "watch"])->middleware("auth")->name("anime.watch");

Route::inertia("/login", "Login/Index")->name("user.login");

Route::get("/user/{user}/watchlist", [UserController::class, "showWatchlist"])->name("user.watchlist");