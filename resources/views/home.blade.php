@extends("layout.root")

@section("body")

<div class="p-2">
    <div id="animespotlight" class="carousel slide mb-4" style="margin-top: -.5rem; margin-left: -.5rem; width: calc(100% + 1rem);" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" class="active bg-light" data-bs-target="#animespotlight" data-bs-slide-to="0" aria-current="true" aria-label="Slide 1"></button>
            @for ($i = 0; $i < count($spotlight) - 1; $i++)
                <button type="button" class="bg-light" data-bs-target="#animespotlight" data-bs-slide-to="{{$i + 1}}" aria-current="true" aria-label="Slide {{ $i + 2}}"></button>
            @endfor
        </div>
        <div class="carousel-inner">
            @foreach ($spotlight as $anime)
                <a href="{{ $_ENV["APP_URL"] }}/anime?id={{ $anime["id"] }}" class="carousel-item {{ $anime["rank"] === 1 ? "active" : "" }}">
                    <img src="{{ $anime["poster"] }}" class="d-block w-100" alt="Image" style="aspect-ratio: 16/4; min-height: 240px; object-fit: cover;">
                    <div class="carousel-caption d-none d-md-block text-light" style="background: radial-gradient(circle, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.4) 27%, rgba(0,0,0,0) 100%);">
                        <h5>{{ $anime["name"] }}</h5>
                        <div class="d-flex justify-content-center gap-1 pb-2 mt-1 mb-0">
                            <p class="d-flex align-items-center gap-2 m-0 px-2 py-1 bg-body-secondary rounded-start"><i class="fi fi-sr-subtitles"></i> {{ $anime["episodes"]["sub"] ?? 0 }}</p>
                            <p class="d-flex align-items-center gap-2 m-0 px-2 py-1 bg-body-tertiary rounded-end"><i class="fi fi-sr-microphone"></i> {{ $anime["episodes"]["dub"] ?? 0 }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#animespotlight" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" style="filter: unset;" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#animespotlight" data-bs-slide="next">
            <span class="carousel-control-next-icon" style="filter: unset;" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    {{-- <div class="alert alert-danger d-flex gap-2 align-items-center" style="margin-top: -1rem;" role="alert">
        <i class="fi fi-sr-diamond-exclamation mt-0"></i>
        <p class="m-0">The provider api is outdated. Update the provider api or the episodes can not be decrypted.</p>
    </div>       --}}
    
    @auth
        <div class="d-flex align-items-center mb-2">
            <h4 class="m-0">Watching</h4>
            <a href="{{ $_ENV["APP_URL"] }}/watchlist" class="ms-auto mb-0">See All</a>
        </div>

        @if (count($history) > 0)
            <div id="animegrid" class="d-grid column-gap-2 mb-4 overflow-hidden" style="--rows-2: {{ count($history) > 4 ? "1fr 1fr" : "1fr" }}; --rows-3: {{ count($history) > 4 ? "1fr 1fr 1fr" : (count($history) > 2 ? "1fr 1fr" : "1fr") }};">
                @foreach ($history as $historyItem)
                    @include("modules.animecard", [
                        "path" => "/watch?id=".$historyItem["animeId"],
                        "title" => $historyItem["title"],
                        "poster" => $historyItem["image"],
                        "currentepisode" => $historyItem["episode"]
                    ])
                @endforeach
            </div>
        @elseif ($user->save_episode_progress === "never")
            <div class="d-grid" style="place-items: center; height: 100px;">
                <p>Enable "Save Episode Progress" in <a href="{{ $_ENV["APP_URL"] }}/account/settings" class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover">Settings</a></p>
            </div>
        @else
            <div class="d-grid" style="place-items: center; height: 100px;">
                <p>Watch anime to appear here</p>
            </div>
        @endif
    @endauth


    <h4>New Episodes</h4>
    <div id="animegrid" class="d-grid column-gap-2 mb-4 overflow-hidden" style="--rows-2: {{ count($latest) > 4 ? "1fr 1fr" : "1fr" }}; --rows-3: {{ count($latest) > 4 ? "1fr 1fr 1fr" : (count($latest) > 2 ? "1fr 1fr" : "1fr") }};">
        @foreach ($latest as $anime)
            @include("modules.animecard", [
                "id" => $anime["id"],
                "title" => $anime["name"],
                "poster" => $anime["poster"],
                "episodes" => $anime["episodes"]
            ])
        @endforeach
    </div>

    <h4>Popular</h4>
    {{-- <div class="d-grid" style="place-items: center; height: 100px;">
        <p>Unavailable</p>
    </div> --}}
    <div id="animegrid" class="d-grid column-gap-2 mb-4 overflow-hidden" style="--rows-2: {{ count($popular) > 4 ? "1fr 1fr" : "1fr" }}; --rows-3: {{ count($popular) > 4 ? "1fr 1fr 1fr" : (count($popular) > 2 ? "1fr 1fr" : "1fr") }};">
        @foreach ($popular as $anime)
            @include("modules.animecard", [
                "id" => $anime["id"],
                "title" => $anime["name"],
                "poster" => $anime["poster"],
                "episodes" => $anime["episodes"]
            ])
        @endforeach
    </div>


    <div class="pt-4 bg-body-tertiary mb-4" style="margin-left: -.5rem; width: calc(100% + 1rem);">
    
        <h4 class="m-0 ms-2">Recent Reviews</h4>

        <div class="d-flex gap-2 mt-2 px-2 pb-4 overflow-x-auto">

            @foreach ($reviews as $review)
                <div class="d-flex flex-column p-2 rounded bg-body-secondary flex-shrink-0" style="width: 300px;">
                
                    <div class="d-flex align-items-center">
                        <p class="text-body-secondary m-0 d-flex align-items-center gap-2" style="font-size: 14px;"><i class="fi fi-sr-user"></i>{{ $review["name"] }}</p>

                        <p class="text-body-secondary m-0 ms-auto" style="font-size: 14px;">{{ $review["timeAgo"] }}</p>
                    </div>
                    <a class="m-0 text-decoration-none text-body mb-2" href="{{config("app.url")}}/anime?id={{ $review["animeId"] }}">{{ $review["title"] }}</a>

                    <div class="d-flex justify-content-evenly py-2 mt-auto">
                        <i class="fi fi-{{ $review["stars"] > 0 ? "s" : "r" }}r-star fi-24"></i>
                        <i class="fi fi-{{ $review["stars"] > 1 ? "s" : "r" }}r-star fi-24"></i>
                        <i class="fi fi-{{ $review["stars"] > 2 ? "s" : "r" }}r-star fi-24"></i>
                        <i class="fi fi-{{ $review["stars"] > 3 ? "s" : "r" }}r-star fi-24"></i>
                        <i class="fi fi-{{ $review["stars"] > 4 ? "s" : "r" }}r-star fi-24"></i>
                    </div>

                </div>
            @endforeach

            @if (count($reviews) === 0)
                <p class="m-0 text-body-secondary">No reviews available</p>
            @endif

        </div>
    
    </div>


    <h4>Trending</h4>
    <div id="animegrid" class="d-grid column-gap-2 mb-4 overflow-hidden" style="--rows-2: {{ count($trending) > 4 ? "1fr 1fr" : "1fr" }}; --rows-3: {{ count($trending) > 4 ? "1fr 1fr 1fr" : (count($trending) > 2 ? "1fr 1fr" : "1fr") }};">
        @foreach ($trending as $anime)
            @include("modules.animecard", [
                "id" => $anime["id"],
                "title" => $anime["name"],
                "poster" => $anime["poster"]
            ])
        @endforeach
    </div>
</div>


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