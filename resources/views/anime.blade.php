@extends("layout.root")

@section("body")
    <div>

        <div class="d-flex flex-column align-items-center py-4">

            <img src="{{ $results["anime"]["info"]["poster"] }}" alt="Image" class="rounded" style="width: 225px;">
            
            <div class="d-flex gap-1 mt-1 mb-0 rounded overflow-hidden">
                @foreach ($results["anime"]["info"]["stats"] as $stat)
                    @if (is_string($stat))
                        <p class="d-flex align-items-center gap-2 m-0 px-2 py-1 bg-body-secondary">{{$stat}}</p>
                    @endif
                @endforeach
                @if ($stars > 0)
                    <p class="d-flex align-items-center gap-2 m-0 px-2 py-1 bg-body-secondary">{{$stars}}<i class="fi fi-sr-star"></i></p>
                @endif
            </div>
            <div class="d-flex gap-1 mt-1 mb-0">
                <p class="d-flex align-items-center gap-2 m-0 px-2 py-1 bg-body-secondary rounded-start"><i class="fi fi-sr-subtitles"></i> {{ $results["anime"]["info"]["stats"]["episodes"]["sub"] ?? 0 }}</p>
                <p class="d-flex align-items-center gap-2 m-0 px-2 py-1 bg-body-tertiary rounded-end"><i class="fi fi-sr-microphone"></i> {{ $results["anime"]["info"]["stats"]["episodes"]["dub"] ?? 0 }}</p>
            </div>

            <h2 class="mt-3 mb-3 selectable">{{ $results["anime"]["info"]["name"] }}</h2>

            <div class="d-flex gap-2 mb-4">
                <a href="{{ $_ENV["APP_URL"] }}/watch?id={{ $results["anime"]["info"]["id"] }}" class="bigbutton btn-primary"><i class="fi fi-sr-play-circle"></i> Watch</a>
                @auth
                    <div class="watchlist-dropdown">
                        <button class="bigbutton btn-secondary"><span>{{ $watchlist["label"] }}</span><i class="fi fi-sr-caret-down"></i></button>
                        <div class="dropdown">
                            <button class="dropdown-item {{ ($watchlist["value"] === "watching") ? "active" : "" }}" data-dropdown-type="watching">Watching</button>
                            <button class="dropdown-item {{ ($watchlist["value"] === "planning") ? "active" : "" }}" data-dropdown-type="planning">Planning</button>
                            <button class="dropdown-item {{ ($watchlist["value"] === "completed") ? "active" : "" }}" data-dropdown-type="completed">Completed</button>
                            <button class="dropdown-item {{ ($watchlist["value"] === "paused") ? "active" : "" }}" data-dropdown-type="paused">Paused</button>
                            <button class="dropdown-item {{ ($watchlist["value"] === "dropped") ? "active" : "" }}" data-dropdown-type="dropped">Dropped</button>
                            <div class="dropdown-item separator"></div>
                            <button class="dropdown-item" data-dropdown-type="remove">Remove</button>
                        </div>
                    </div>
                @endauth
            </div>

            <div class="d-flex flex-wrap justify-content-center gap-2 px-2" style="width: min(1000px, 100%);">
                @foreach ($results["seasons"] as $season)
                    <a href="{{ $_ENV["APP_URL"] }}/anime?id={{ $season["id"] }}" class="d-grid bg-body-primary text-center text-light text-decoration-none border {{ $season["isCurrent"] ? "border-secondary" : "" }} rounded" style="width: 150px; height: 70px; place-items:center; font-size: 14px;">{{ $season["title"] }}</a>
                @endforeach

            </div>

        </div>

        <div class="p-2">
            <h4 class="fs-5 mb-2">Related Anime</h4>
            <div id="animegrid" class="d-grid column-gap-2 mb-4 overflow-hidden" style="--rows-2: {{ count($results["relatedAnimes"]) > 4 ? "1fr 1fr" : "1fr" }}; --rows-3: {{ count($results["relatedAnimes"]) > 4 ? "1fr 1fr 1fr" : (count($results["relatedAnimes"]) > 2 ? "1fr 1fr" : "1fr") }};">
                @foreach ($results["relatedAnimes"] as $anime)
                    @include("modules.animecard", [
                        "id" => $anime["id"],
                        "title" => $anime["name"],
                        "poster" => $anime["poster"],
                        "episodes" => $anime["episodes"]
                    ])
                @endforeach
            </div>

            <h4 class="fs-5 mb-2">Recommended Anime</h4>
            <div id="animegrid" class="d-grid column-gap-2 mb-4 overflow-hidden" style="--rows-2: {{ count($results["recommendedAnimes"]) > 4 ? "1fr 1fr" : "1fr" }}; --rows-3: {{ count($results["recommendedAnimes"]) > 4 ? "1fr 1fr 1fr" : (count($results["recommendedAnimes"]) > 2 ? "1fr 1fr" : "1fr") }};">
                @foreach ($results["recommendedAnimes"] as $anime)
                    @include("modules.animecard", [
                        "id" => $anime["id"],
                        "title" => $anime["name"],
                        "poster" => $anime["poster"],
                        "episodes" => $anime["episodes"]
                    ])
                @endforeach
            </div>
        </div>
        

    </div>

@endsection

@section("head")

    <script src="{{config("app.url")}}/wanime-style/modules-js/watchlist-dropdown.js"></script>
    <style>

        #animegrid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); 
            grid-auto-rows: 0; 
            grid-template-rows: 1fr;
            margin-top: -.5rem !important;
        }

        @media only screen and (max-width: 847px) {
            #animegrid {
                grid-template-rows: var(--rows-2);
            }
        }

        @media only screen and (max-width: 511px) {
            #animegrid {
                grid-template-rows: var(--rows-3);
            }
        }

    </style>
    <script>

        function watchlistStatusUpdate(state) {
            fetch(`{{ $_ENV["APP_URL"] }}/api/watchlist/{{ $results["anime"]["info"]["id"] }}`, {
                method: "PUT",
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    "status": state,
                    "anime": {
                        "title": "{{ $results["anime"]["info"]["name"] }}",
                        "image": "{{ $results["anime"]["info"]["poster"] }}"
                    }
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            });
        }

    </script>
    
@endsection