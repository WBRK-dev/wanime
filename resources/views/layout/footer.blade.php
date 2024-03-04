<div class="bg-body-tertiary p-4 d-flex gap-4 justify-content-around flex-wrap">

    <div>
        <h4 class="fs-5">About</h4>
        <p class="m-0 text-body-secondary mb-1">Made by WBR_K</p>
        <p class="m-0 text-body-secondary mb-1">© {{ $_ENV["APP_COPY"] }}</p>
        <p class="m-0 text-body-secondary">{{ $_ENV["APP_VERSION"] }}</p>
    </div>

    <div>
        <h4 class="fs-5">More</h4>
        <a class="d-block text-body-secondary mb-1" href="/gogoviewer/" target="_blank">Gogoviewer</a>
        <a class="d-block text-body-secondary mb-1 disabled" href="#">WManga</a>
        <a class="d-block text-body-secondary" href="{{config("app.url")}}/resourcesused">Resources Used</a>
    </div>

</div>