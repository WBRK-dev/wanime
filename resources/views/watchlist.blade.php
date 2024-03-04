@extends("layout.root")



@section("body")
    
    <div class="p-2">
        
        <div class="d-flex justify-content-center">
            <div class="btn-group flex-wrap rounded overflow-hidden">
                <a href="{{ $_ENV["APP_URL"] }}/watchlist?app=completed" class="btn btn-primary rounded-0 {{ request()->input("app") == "completed" ? "active" : "" }}">Completed</a>
                <a href="{{ $_ENV["APP_URL"] }}/watchlist?app=planning" class="btn btn-primary rounded-0 {{ request()->input("app") == "planning" ? "active" : "" }}">Planning</a>
                <a href="{{ $_ENV["APP_URL"] }}/watchlist" class="btn btn-primary rounded-0 {{ request()->input("app") == "" ? "active" : "" }}" aria-current="page">Watching</a>
                <a href="{{ $_ENV["APP_URL"] }}/watchlist?app=paused" class="btn btn-primary rounded-0 {{ request()->input("app") == "paused" ? "active" : "" }}" aria-current="page">Paused</a>
                <a href="{{ $_ENV["APP_URL"] }}/watchlist?app=dropped" class="btn btn-primary rounded-0 {{ request()->input("app") == "dropped" ? "active" : "" }}" aria-current="page">Dropped</a>
            </div>            
        </div>

        <div class="d-grid column-gap-2 mt-2 overflow-hidden" style="grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));">
            @foreach ($anime as $animeItem)
                @include("modules.animecard", [
                    "id" => $animeItem["animeId"],
                    "title" => $animeItem["title"],
                    "poster" => $animeItem["image"]
                ])
            @endforeach
        </div>

    </div>

@endsection