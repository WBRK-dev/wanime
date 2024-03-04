@extends("layout.root")

@section("body")

<div>
    <div>

        @if ($results["totalPages"] > 1)
            <nav aria-label="Page navigation" class="ms-2 mt-4 d-flex justify-content-center">
                <ul class="pagination">
                    @for ($i = 0; $i < $results["totalPages"]; $i++)
                        @if ($i+1 >= $results["currentPage"] - 10 && $i+1 <= $results["currentPage"] + 10)
                            <li class="page-item"><a class="page-link {{ $i+1 === $results["currentPage"] ? "active" : "" }}" href="{{ $_ENV["APP_URL"] }}/search?search={{ $_GET["search"] }}&page={{ $i + 1 }}">{{ $i + 1 }}</a></li>
                        @endif
                    @endfor
                </ul>
            </nav>
        @endif
    
    
        <div class="d-grid gap-2 p-2" style="grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));">
            @foreach ($results["animes"] as $anime)
                @include("modules.animecard", [
                    "id" => $anime["id"],
                    "title" => $anime["name"],
                    "poster" => $anime["poster"],
                    "episodes" => $anime["episodes"]
                ])
            @endforeach
        </div>
    
        @if ($results["totalPages"] > 1)
            <nav aria-label="Page navigation" class="ms-2 mt-3 d-flex justify-content-center">
                <ul class="pagination">
                    @for ($i = 0; $i < $results["totalPages"]; $i++)
                        @if ($i+1 >= $results["currentPage"] - 10 && $i+1 <= $results["currentPage"] + 10)
                            <li class="page-item"><a class="page-link {{ $i+1 === $results["currentPage"] ? "active" : "" }}" href="{{ $_ENV["APP_URL"] }}/search?search={{ $_GET["search"] }}&page={{ $i + 1 }}">{{ $i + 1 }}</a></li>
                        @endif
                    @endfor
                </ul>
            </nav>
        @endif

    </div>

    <div class="d-grid gap-2 p-2" style="grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));">
        @foreach ($results["mostPopularAnimes"] as $anime)
            @include("modules.animecard", [
                "id" => $anime["id"],
                "title" => $anime["name"],
                "poster" => $anime["poster"],
            ])
        @endforeach
    </div>
</div>


@endsection