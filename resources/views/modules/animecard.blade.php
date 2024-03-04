<a href="{{ $_ENV["APP_URL"] }}{{ $path ?? "/anime?id=$id" }}" class="card text-decoration-none w-100 mt-2">
    <img src="{{ $poster }}" class="card-img-top w-100" alt="Image" style="aspect-ratio: 1/1.36; object-fit: cover;">
    <div class="card-body p-2">
        <h5 class="card-title fs-6 mb-0">{{ $title }}</h5>
    </div>
    @if (isset($episodes))
        <div class="d-flex justify-content-center gap-1 mt-1 me-1 mb-0 position-absolute top-0 start-50 translate-middle-x">
            <p class="d-flex align-items-center gap-2 fs-6 m-0 px-2 py-1 bg-body-secondary rounded-start"><i class="fi fi-16 fi-sr-subtitles"></i> {{ $episodes["sub"] ?? 0 }}</p>
            <p class="d-flex align-items-center gap-2 fs-6 m-0 px-2 py-1 bg-body-tertiary rounded-end"><i class="fi fi-16 fi-sr-microphone"></i> {{ $episodes["dub"] ?? 0 }}</p>
        </div>
    @endif
    @if (isset($currentepisode))
    <div class="d-flex justify-content-center gap-1 mt-1 me-1 mb-0 position-absolute top-0 start-50 translate-middle-x">
        <p class="d-flex align-items-center gap-2 fs-6 m-0 px-2 py-1 bg-body-secondary rounded"><i class="fi fi-12 fi-sr-play"></i> {{ ($currentepisode + 1) ?? 1 }}</p>
    </div>
    @endif
</a>