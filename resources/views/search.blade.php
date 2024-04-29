@extends("layout.root")

@section("body")

<div class="search-wrapper bg-body-tertiary">
    <div class="results-wrapper p-2 pt-0 bg-body">

        @if ($pages["active"])
            
            <div class="d-flex justify-content-center my-3"><div class="pagination-list">

                @if ($pages["prevAll"])
                    <a href="{{ $pages["url"] }}&page={{ $pages["prevAll"]["page"] }}" class="pagination-item pagination-item-fi"><i class="fi fi-sr-angle-double-small-left"></i></a>
                @endif
                @if ($pages["prev"])
                    <a href="{{ $pages["url"] }}&page={{ $pages["prev"]["page"] }}" class="pagination-item pagination-item-fi"><i class="fi fi-sr-angle-small-left"></i></a>
                @endif

                @foreach ($pages["pages"] as $page)
                    <a href="{{ $pages["url"] }}&page={{ $page["page"] }}" class="pagination-item {{ $page["current"] ? "active" : "" }}">{{ $page["page"] }}</a>
                @endforeach
                
                @if ($pages["next"])
                    <a href="{{ $pages["url"] }}&page={{ $pages["next"]["page"] }}" class="pagination-item pagination-item-fi"><i class="fi fi-sr-angle-small-right"></i></a>
                @endif
                @if ($pages["nextAll"])
                    <a href="{{ $pages["url"] }}&page={{ $pages["nextAll"]["page"] }}" class="pagination-item pagination-item-fi"><i class="fi fi-sr-angle-double-small-right"></i></a>
                @endif

            </div></div>

        @endif
    
    
        <div class="d-grid gap-2" style="grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));">
            @foreach ($results["animes"] as $anime)
                @include("modules.animecard", [
                    "id" => $anime["id"],
                    "title" => $anime["name"],
                    "poster" => $anime["poster"],
                    "episodes" => $anime["episodes"]
                ])
            @endforeach
        </div>
    
        @if ($pages["active"])
            
            <div class="d-flex justify-content-center my-3"><div class="pagination-list">

                @if ($pages["prevAll"])
                    <a href="{{ $pages["url"] }}&page={{ $pages["prevAll"]["page"] }}" class="pagination-item pagination-item-fi"><i class="fi fi-sr-angle-double-small-left"></i></a>
                @endif
                @if ($pages["prev"])
                    <a href="{{ $pages["url"] }}&page={{ $pages["prev"]["page"] }}" class="pagination-item pagination-item-fi"><i class="fi fi-sr-angle-small-left"></i></a>
                @endif

                @foreach ($pages["pages"] as $page)
                    <a href="{{ $pages["url"] }}&page={{ $page["page"] }}" class="pagination-item {{ $page["current"] ? "active" : "" }}">{{ $page["page"] }}</a>
                @endforeach
                
                @if ($pages["next"])
                    <a href="{{ $pages["url"] }}&page={{ $pages["next"]["page"] }}" class="pagination-item pagination-item-fi"><i class="fi fi-sr-angle-small-right"></i></a>
                @endif
                @if ($pages["nextAll"])
                    <a href="{{ $pages["url"] }}&page={{ $pages["nextAll"]["page"] }}" class="pagination-item pagination-item-fi"><i class="fi fi-sr-angle-double-small-right"></i></a>
                @endif

            </div></div>

        @endif

    </div>

    <div class="most-popular-wrapper d-flex flex-column gap-2 p-2 bg-body-tertiary">
        <h4 class="fs-5">Most Popular</h4>
        @foreach ($results["mostPopularAnimes"] as $anime)
            <a href="{{config("app.url")}}/anime?id={{ $anime["id"] }}" class="most-popular-anime no-a d-flex align-items-center gap-2">
                <img src="{{ $anime["poster"] }}">
                <div>
                    <p class="title">{{ $anime["name"] }}</p>
                    <div class="episodes">
                        <p class="episode rounded-start"><i class="fi fi-16 fi-sr-subtitles"></i> {{ $anime["episodes"]["sub"] ?? 0 }}</p>
                        <p class="episode bg-body rounded-end"><i class="fi fi-16 fi-sr-microphone"></i> {{ $anime["episodes"]["dub"] ?? 0 }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>


@endsection

@section("head")

    <style>

        .search-wrapper {
            display: grid;
            grid-template-columns: 1fr 300px;
        }

        .results-wrapper {
            border-top-right-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        .most-popular-anime img {
            aspect-ratio: 1/1.30; 
            object-fit: cover;
            height: 5rem;
            border-radius: .25rem;
        }

        .most-popular-anime .title {
            font-weight: 700;
            font-size: 16px;

            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .most-popular-anime .episodes {
            position: unset;
            left: unset; top: unset;
            transform: unset;
            justify-content: start;
        }

        @media only screen and (max-width: 980px) {
            .search-wrapper {
                grid-template-columns: 1fr;
            }

            .results-wrapper {
                border-radius: 0;
            }

            .most-popular-wrapper {
                border-bottom: 1px solid var(--bs-border-color);
                padding-bottom: 1.5rem !important;
            }
        }

    </style>

@endsection