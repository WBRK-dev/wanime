<div id="episodes" class="watch-episodes {{ $episodes["totalEpisodes"] <= 12 ? "list" : "grid" }}" style="max-height: 450px; {{ $episodes["totalEpisodes"] > 12 ? "grid-template-columns: repeat(auto-fill, minmax(40px, 1fr))" : "grid-template-columns: repeat(auto-fill, minmax(40px, 1fr))" }}">
    @if ($episodes["totalEpisodes"] <= 12)
        @for ($i = 0; $i < count($episodes["episodes"]); $i++)
            <button class="{{ $i === $history ? "active" : "" }}" onclick="epClick({{ $i }}, '{{ $episodes['episodes'][$i]['episodeId'] }}')"><p class="number">{{ $episodes["episodes"][$i]["number"] }}:</p><p class="text">{{ $episodes["episodes"][$i]["title"] }}</p></button>
        @endfor
    @else
        @for ($i = 0; $i < count($episodes["episodes"]); $i++)
            <button class="{{ $i === $history ? "active" : "" }}" onclick="epClick({{ $i }}, '{{ $episodes['episodes'][$i]['episodeId'] }}')">{{ $episodes["episodes"][$i]["number"] }}</button>
        @endfor
    @endif
</div>

@section("head.episodes")

<script>
    function epClick(i, ep) {
        $("#episodes button").removeClass("active");

        $($("#episodes button")[i]).addClass("active");

        if (gogoProvider) loadGogoEp(i);
        else loadEpId(i, ep);
    }
</script>

@endsection