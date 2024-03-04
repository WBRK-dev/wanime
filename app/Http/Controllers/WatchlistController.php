<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWatchlistRequest;
use App\Http\Requests\UpdateWatchlistRequest;
use App\Models\Watchlist;

class WatchlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWatchlistRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Watchlist $watchlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Watchlist $watchlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWatchlistRequest $request, Watchlist $watchlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Watchlist $watchlist)
    {
        //
    }
}
