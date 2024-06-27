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

            <div class="d-grid mt-4 w-100 bg-body-tertiary" style="grid-template-columns: 1fr 500px;" id="moreInfo">
                <div class="py-4 px-3">

                    <h4 class="fs-5 mb-2">Characters & Voice Actors</h4>
                    @if (count($results["anime"]["info"]["charactersVoiceActors"]) > 0)
                        
                        <div class="character-list">
                            @foreach ($results["anime"]["info"]["charactersVoiceActors"] as $collection)
                                <div class="d-flex justify-content-between bg-body-secondary p-2 rounded">
                                    <div class="d-flex gap-2 align-items-center">
                                        <img src="{{ $collection["character"]["poster"] }}" class="rounded-circle" style="height: 50px; aspect-ratio: 1; object-fit: cover;" >
                                        <div>
                                            <p class="fw-bold one-line">{{ $collection["character"]["name"] }}</p>
                                            <p class="text-body-secondary one-line">{{ $collection["character"]["cast"] }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 align-items-center">
                                        <div>
                                            <p class="fw-bold text-end one-line">{{ $collection["voiceActor"]["name"] }}</p>
                                            <p class="text-end text-body-secondary one-line">{{ $collection["voiceActor"]["cast"] }}</p>
                                        </div>
                                        <img src="{{ $collection["voiceActor"]["poster"] }}" class="rounded-circle" style="height: 50px; aspect-ratio: 1; object-fit: cover;" >
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    
                    @else
                        <p class="text-body-secondary">No characters & voice actors found.</p>
                    @endif

                    <h4 class="fs-5 mb-2 mt-4">Promotion Videos</h4>
                    @if (count($results["anime"]["info"]["promotionalVideos"]) > 0)

                        <div class="d-grid gap-2" style="grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));">
                        
                            @foreach ($results["anime"]["info"]["promotionalVideos"] as $video)
                                
                                <div class="bg-body-secondary rounded overflow-hidden cu-pointer" onclick="openVideoPopup('{{ $video["source"] }}')">
                                    <img src="{{ $video["thumbnail"] }}" class="w-100" style="aspect-ratio: 16/9; object-fit: cover;">
                                    <div class="py-2"><p class="text-center one-line">{{ $video["title"] }}</p></div>
                                </div>

                            @endforeach

                        </div>

                    @else
                        <p class="text-body-secondary">No promotion videos found.</p>
                    @endif

                </div>
                <div class="d-flex flex-column gap-1 bg-body-secondary py-4 px-3">
                    @if (isset($results["anime"]["moreInfo"]["japanese"]))
                        <p class="one-line"><span class="fw-bold">Japenese</span>: {{ $results["anime"]["moreInfo"]["japanese"] }}</p>
                    @endif
                    @if (isset($results["anime"]["moreInfo"]["synonyms"]))
                        <p class="one-line"><span class="fw-bold">Synonyms</span>: {{ $results["anime"]["moreInfo"]["synonyms"] }}</p>
                    @endif
                    @if (isset($results["anime"]["moreInfo"]["aired"]))
                        <p class="one-line"><span class="fw-bold">Aired</span>: {{ $results["anime"]["moreInfo"]["aired"] }}</p>
                    @endif
                    @if (isset($results["anime"]["moreInfo"]["premiered"]))
                        <p class="one-line"><span class="fw-bold">Premiered</span>: {{ $results["anime"]["moreInfo"]["premiered"] }}</p>
                    @endif
                    @if (isset($results["anime"]["moreInfo"]["duration"]))
                        <p class="one-line"><span class="fw-bold">Duration</span>: {{ $results["anime"]["moreInfo"]["duration"] }}</p>
                    @endif
                    @if (isset($results["anime"]["moreInfo"]["status"]))
                        <p class="one-line"><span class="fw-bold">Status</span>: {{ $results["anime"]["moreInfo"]["status"] }}</p>
                    @endif
                    @if (isset($results["anime"]["moreInfo"]["malscore"]))
                        <p class="one-line"><span class="fw-bold">Malscore</span>: {{ $results["anime"]["moreInfo"]["malscore"] }}</p>
                    @endif

                    @if (isset($results["anime"]["moreInfo"]["genres"]) && gettype($results["anime"]["moreInfo"]["genres"]) === "string")
                        <p class="one-line"><span class="fw-bold">Genres</span>: {{ $results["anime"]["moreInfo"]["genres"] }}</p>
                    @elseif (isset($results["anime"]["moreInfo"]["genres"]) && gettype($results["anime"]["moreInfo"]["genres"]) === "array")
                        <p class="one-line"><span class="fw-bold">Genres</span>: 
                            @foreach ($results["anime"]["moreInfo"]["genres"] as $genre)
                                {{ $genre }},
                            @endforeach
                        </p>
                    @endif

                    @if (isset($results["anime"]["moreInfo"]["studios"]) && gettype($results["anime"]["moreInfo"]["studios"]) === "string")
                        <p class="one-line"><span class="fw-bold">Studios</span>: {{ $results["anime"]["moreInfo"]["studios"] }}</p>
                    @elseif (isset($results["anime"]["moreInfo"]["studios"]) && gettype($results["anime"]["moreInfo"]["studios"]) === "array")
                        <p class="one-line"><span class="fw-bold">Studios</span>: 
                            @foreach ($results["anime"]["moreInfo"]["studios"] as $studio)
                                {{ $studio }},
                            @endforeach
                        </p>
                    @endif

                    @if (isset($results["anime"]["moreInfo"]["producers"]) && gettype($results["anime"]["moreInfo"]["producers"]) === "string")
                        <p class="one-line"><span class="fw-bold">Producers</span>: {{ $results["anime"]["moreInfo"]["producers"] }}</p>
                    @elseif (isset($results["anime"]["moreInfo"]["producers"]) && gettype($results["anime"]["moreInfo"]["producers"]) === "array")
                        <p class="one-line"><span class="fw-bold">Producers</span>: 
                            @foreach ($results["anime"]["moreInfo"]["producers"] as $producer)
                                {{ $producer }},
                            @endforeach
                        </p>
                    @endif
                </div>
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

    <div class="videopopup d-none">
        <iframe src="" frameborder="0"></iframe>
        <button class="cu-pointer" onclick="hideVideoPopup()"><i class="fi fi-sr-cross"></i></button>
    </div>

@endsection

@section("head")

    <script src="{{config("app.url")}}/wanime-style-1/modules-js/watchlist-dropdown.js"></script>
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

        .character-list {
            display: grid; gap: .5rem;
            grid-template-columns: 1fr 1fr 1fr;

            font-size: .9rem;
        }

        @media only screen and (max-width: 1720px) {
            .character-list {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media only screen and (max-width: 1330px) {
            .character-list {
                grid-template-columns: 1fr;
            }
        }
        @media only screen and (max-width: 970px) {
            #moreInfo {
                grid-template-columns: 1fr !important;
            }
            #moreInfo > div:first-child {
                order: 1;
            }
        }

        .videopopup {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;

            background-color: #00000070;
        }

        .videopopup iframe {
            display: block;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: calc(100% - 2rem);
            aspect-ratio: 16/9;
            max-height: calc(100% - 2rem);

            background-color: transparent;
        }

        .videopopup button {
            padding: .5rem;
            border: none;
            background-color: var(--bs-secondary-bg);
            border-radius: .5rem;

            position: absolute;
            top: 2rem; right: 2rem;

            font-size: 18px;
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

        function openVideoPopup(videoUrl) {
            $(".videopopup iframe").attr("src", videoUrl);
            $(".videopopup").removeClass("d-none");
        }

        function hideVideoPopup() {
            $(".videopopup iframe").attr("src", "");
            $(".videopopup").addClass("d-none");
        }

    </script>
    
@endsection