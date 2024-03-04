<a href="#" class="animecard">
    <img src="{{ $poster }}" class="w-100 rounded" alt="Image" style="aspect-ratio: 1/1.36; object-fit: cover;">
    <div class="py-2">
        <h5 class="fs-6">{{ $title }}</h5>
    </div>

    @if (isset($episodes))
        <div class="episodes">
            <p class="episode rounded-start"><i class="fi fi-16 fi-sr-subtitles"></i> {{ $episodes["sub"] ?? 0 }}</p>
            <p class="episode bg-body-tertiary rounded-end"><i class="fi fi-16 fi-sr-microphone"></i> {{ $episodes["dub"] ?? 0 }}</p>
        </div>
    @endif
    @if (isset($currentepisode))
    <div class="episodes">
        <p class="episode rounded"><i class="fi fi-12 fi-sr-play"></i> {{ ($currentepisode + 1) ?? 1 }}</p>
    </div>
    @endif

</a>