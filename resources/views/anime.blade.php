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

            <h2 class="mt-3 mb-3">{{ $results["anime"]["info"]["name"] }}</h2>

            <div class="d-flex gap-2 mb-4">
                <a href="{{ $_ENV["APP_URL"] }}/watch?id={{ $results["anime"]["info"]["id"] }}" class="btn btn-primary">Watch</a>
                @auth
                    <div class="btn-group dropdown-left">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $watchlist["label"] }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button onclick="dropdownHandler(this, 'watching')" class="dropdown-item {{ ($watchlist["value"] === "watching") ? "active" : "" }}" href="#">Watching</button></li>
                            <li><button onclick="dropdownHandler(this, 'planning')" class="dropdown-item {{ ($watchlist["value"] === "planning") ? "active" : "" }}" href="#">Planning</button></li>
                            <li><button onclick="dropdownHandler(this, 'completed')" class="dropdown-item {{ ($watchlist["value"] === "completed") ? "active" : "" }}" href="#">Completed</button></li>
                            <li><button onclick="dropdownHandler(this, 'paused')" class="dropdown-item {{ ($watchlist["value"] === "paused") ? "active" : "" }}" href="#">Paused</button></li>
                            <li><button onclick="dropdownHandler(this, 'dropped')" class="dropdown-item {{ ($watchlist["value"] === "dropped") ? "active" : "" }}" href="#">Dropped</button></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><button onclick="removeButton(this)" class="dropdown-item {{ ($watchlist["value"] === "") ? "disabled" : "" }}" href="#">Remove</button></li>
                        </ul>
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
            <h4>Related Anime</h4>
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

            <h4>Recommended Anime</h4>
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


    <script>

        function apiCall(state) {
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

        function dropdownHandler(elem, state) {

            $(elem).parent().parent().children().children().removeClass("active");
            $(elem).parent().parent().children().children().removeClass("disabled");
            $(elem).parent().parent().parent().find("button").first().text($(elem).text());
            $(elem).addClass("active");

            apiCall(state);

        }

        function removeButton(elem) {

            $(elem).parent().parent().children().children().removeClass("active");
            $(elem).parent().parent().parent().find("button").first().text("WatchList");
            $(elem).addClass("disabled")

            apiCall("remove");

        }

    </script>
@endsection

@section("head")

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
    
@endsection