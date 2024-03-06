<div id="episodes" class="watch-episodes {{ $episodes["totalEpisodes"] <= 12 ? "list" : "grid" }}" style="max-height: 450px; {{ $episodes["totalEpisodes"] > 12 ? "grid-template-columns: repeat(auto-fill, minmax(40px, 1fr))" : "grid-template-columns: repeat(auto-fill, minmax(40px, 1fr))" }}">
    @if ($episodes["totalEpisodes"] <= 12)
        @foreach ($episodes["episodes"] as $episode)
            <button class="btn btn-secondary">{{ $episode["number"] }}</button>
        @endforeach
    @else
        @for ($i = 0; $i < count($episodes["episodes"]); $i++)
            <button class="btn {{ $i === $history ? "btn-success" : "btn-secondary" }} px-0" onclick="epClick({{ $i }}, '{{ $episodes['episodes'][$i]['episodeId'] }}')">{{ $episodes["episodes"][$i]["number"] }}</button>
        @endfor
    @endif
</div>

@section("head.episodes")

<script>
    function epClick(i, ep) {
        $("#episodes button").removeClass("btn-success");
        $("#episodes button").addClass("btn-secondary");

        $($("#episodes button")[i]).addClass("btn-success");
        $($("#episodes button")[i]).removeClass("btn-secondary");

        if (gogoProvider) loadGogoEp(i);
        else loadEpId(i, ep);
    }
</script>

@endsection