@extends("layout.root")



@section("body")
    
    <div class="p-2">
        
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ $_ENV["APP_URL"] }}/watchlist?app=completed" class="btn btn-{{ request()->input("app") == "completed" ? "primary" : "secondary" }}">Completed</a>
            <a href="{{ $_ENV["APP_URL"] }}/watchlist?app=planning" class="btn btn-{{ request()->input("app") == "planning" ? "primary" : "secondary" }}">Planning</a>
            <a href="{{ $_ENV["APP_URL"] }}/watchlist" class="btn btn-{{ request()->input("app") == "" ? "primary" : "secondary" }}" aria-current="page">Watching</a>
            <a href="{{ $_ENV["APP_URL"] }}/watchlist?app=paused" class="btn btn-{{ request()->input("app") == "paused" ? "primary" : "secondary" }}" aria-current="page">Paused</a>
            <a href="{{ $_ENV["APP_URL"] }}/watchlist?app=dropped" class="btn btn-{{ request()->input("app") == "dropped" ? "primary" : "secondary" }}" aria-current="page">Dropped</a>
        </div>

        <div class="d-grid column-gap-2 overflow-hidden" style="grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));">
            @foreach ($anime as $animeItem)
                @include("modules.animecard", [
                    "id" => $animeItem->animeId,
                    "title" => $animeItem->anime->title,
                    "poster" => $animeItem->anime->image
                ])
            @endforeach
        </div>

    </div>

@endsection