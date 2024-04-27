<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\WatchListController;
use App\Http\Controllers\WatchController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CorsController;
use App\Http\Controllers\HitController;



require __DIR__.'/auth.php';

Route::get('/', [HomeController::class, "home"]);

Route::get('/search', [SearchController::class, "home"]);

Route::get('/anime', [AnimeController::class, "home"]);

Route::get('/account', [AccountController::class, "account"]);

Route::get('/account/settings', [AccountController::class, "settings"])->middleware("auth");

Route::get('/watchlist', [WatchListController::class, "main"])->middleware("auth");

Route::get('/account/register', [RegisterController::class, "show"]);
Route::post('/account/register', [RegisterController::class, "register"]);

Route::get('/watch', [WatchController::class, "show"]);
// Route::get('/watch', [WatchController::class, "show"])->middleware("auth");

Route::view("/subscriptions", "subscriptions.index");
Route::view("/subscriptions/buy", "subscriptions.buy");

Route::view("/resourcesused", "resourcesused");

Route::get("/login", function () {
    if (Auth::check()) return redirect("/");
    else return view("account.login");
});

// Admin ------

Route::prefix("admin")->middleware("admin")->group(function() {
    
    Route::get('/', [AdminController::class, 'panel']);

    Route::get('/registrations', [AdminController::class, 'registrations']);
    Route::post('/registrations', [AdminController::class, 'registrationAction']);

});


// API -----

Route::prefix("api")->group(function() {
    
    Route::put("/account/{setting}", [AccountController::class, "update"])->middleware("auth");
    
    Route::put("/episode/{animeid}", [WatchController::class, "epupdate"])->middleware("auth");
    
    Route::put("/watchlist/{animeid}", [WatchListController::class, "update"])->middleware("auth");

    Route::post("/star", [WatchController::class, "star"])->middleware("auth");

    Route::get('/cors', [CorsController::class, "cors"]);

    Route::post('/hit', [HitController::class, "hit"]);

});