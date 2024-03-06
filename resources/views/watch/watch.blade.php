@extends("layout.root")

@section("body")

    <div id="padderoutside" class="p-4">

        <div class="f-cont-video d-grid gap-4" style="grid-template-columns: 1fr min(400px, 21%);">
            <div class="s-cont-video d-grid gap-4" style="grid-template-columns: 300px 1fr;">

                <div class="d-flex flex-column gap-4">
                    <button class="btn btn-secondary w-100 text-nowrap overflow-hidden d-none" id="gogoanimeselectbutton" onclick="showGogoDialog()">No anime selected</button>
                    @include("watch.episodes", ["episodes" => $episodes])
                </div>

                <div class="d-flex flex-column gap-4">
                    @include("watch.video")
                    @include("watch.servers")
                </div>

            </div>

            <div class="d-flex flex-column align-items-center">
                <img class="rounded" src="{{ $anime["anime"]["info"]["poster"] }}" alt="Image" style="width: min(225px, 100%);">
                <div class="d-flex gap-1 mt-1 mb-1 rounded overflow-hidden">
                    @foreach ($anime["anime"]["info"]["stats"] as $stat)
                        @if (is_string($stat))
                            <p class="d-flex align-items-center gap-2 m-0 px-2 py-1 bg-body-secondary">{{$stat}}</p>
                        @endif
                    @endforeach
                    @if (floatval($stars["avg"]) > 0)
                        <p class="d-flex align-items-center gap-2 m-0 px-2 py-1 bg-body-secondary">{{floatval($stars["avg"])}}<i class="fi fi-sr-star"></i></p>
                    @endif
                </div>
                <div class="d-flex gap-1 mb-4">
                    <p class="d-flex align-items-center gap-2 m-0 px-2 py-1 bg-body-secondary rounded-start"><i class="fi fi-sr-subtitles"></i> {{ $anime["anime"]["info"]["stats"]["episodes"]["sub"] ?? 0 }}</p>
                    <p class="d-flex align-items-center gap-2 m-0 px-2 py-1 bg-body-tertiary rounded-end"><i class="fi fi-sr-microphone"></i> {{ $anime["anime"]["info"]["stats"]["episodes"]["dub"] ?? 0 }}</p>
                </div>
                <h4 class="fs-5 mb-4 selectable">{{ $anime["anime"]["info"]["name"] }}</h4>
                <div class="w-100 overflow-auto mb-4" style="height: 100px;">{{ $anime["anime"]["info"]["description"] }}</div>

                @if (count($anime["seasons"]))
                    <div class="d-flex flex-wrap justify-content-center gap-2 px-2 mb-4" style="width: min(1000px, 100%);">
                        @foreach ($anime["seasons"] as $season)
                            <a href="{{ $_ENV["APP_URL"] }}/anime?id={{ $season["id"] }}" class="d-grid bg-body-primary text-center text-light text-decoration-none border {{ $season["isCurrent"] ? "border-secondary" : "" }} rounded" style="width: 150px; height: 70px; place-items:center; font-size: 14px;">{{ $season["title"] }}</a>
                        @endforeach

                    </div>
                @endif


                @auth
                    <div class="bg-body-secondary rounded p-2" style="width: min(300px, 100%);" id="voting">
                        <div class="d-flex align-items-center">
                            <p class="m-0">Vote for this anime!</p>
                            <p class="m-0 ms-auto text-body-secondary d-flex align-items-center gap-2"><span data-anime-vote-stars>{{ floatval($stars["avg"]) }}</span><i class="fi fi-sr-star"></i></p>
                        </div>
                        <div class="d-flex align-items-center justify-content-evenly pt-1">
                            <button class="bg-transparent border-0 m-0 py-1 flex-grow-1 d-grid" style="place-items: center;" id="votestar" onmouseover="updateStarCss(this, true, 1)" onmouseout="updateStarCss(this, false, 1)" onclick="voteStarClick(1)"><i class="fi fi-{{ $stars["selected"] > 0 ? "s" : "r" }}r-star fi-24 text-body-secondary pe-none"></i></button>
                            <button class="bg-transparent border-0 m-0 py-1 flex-grow-1 d-grid" style="place-items: center;" id="votestar" onmouseover="updateStarCss(this, true, 2)" onmouseout="updateStarCss(this, false, 2)" onclick="voteStarClick(2)"><i class="fi fi-{{ $stars["selected"] > 1 ? "s" : "r" }}r-star fi-24 text-body-secondary pe-none"></i></button>
                            <button class="bg-transparent border-0 m-0 py-1 flex-grow-1 d-grid" style="place-items: center;" id="votestar" onmouseover="updateStarCss(this, true, 3)" onmouseout="updateStarCss(this, false, 3)" onclick="voteStarClick(3)"><i class="fi fi-{{ $stars["selected"] > 2 ? "s" : "r" }}r-star fi-24 text-body-secondary pe-none"></i></button>
                            <button class="bg-transparent border-0 m-0 py-1 flex-grow-1 d-grid" style="place-items: center;" id="votestar" onmouseover="updateStarCss(this, true, 4)" onmouseout="updateStarCss(this, false, 4)" onclick="voteStarClick(4)"><i class="fi fi-{{ $stars["selected"] > 3 ? "s" : "r" }}r-star fi-24 text-body-secondary pe-none"></i></button>
                            <button class="bg-transparent border-0 m-0 py-1 flex-grow-1 d-grid" style="place-items: center;" id="votestar" onmouseover="updateStarCss(this, true, 5)" onmouseout="updateStarCss(this, false, 5)" onclick="voteStarClick(5)"><i class="fi fi-{{ $stars["selected"] > 4 ? "s" : "r" }}r-star fi-24 text-body-secondary pe-none"></i></button>
                        </div>
                    </div>
                @endauth

            </div>
        </div>

        <h4 class="mt-4">Recommended</h4>
        <div class="d-grid column-gap-2 mb-4 overflow-hidden" style="grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); grid-auto-rows: 0; grid-template-rows: 1fr;">
            @foreach ($anime["recommendedAnimes"] as $animeR)
                @include("modules.animecard", [
                    "id" => $animeR["id"],
                    "title" => $animeR["name"],
                    "poster" => $animeR["poster"],
                    "episodes" => $animeR["episodes"]
                ])
            @endforeach
        </div>

        @include("watch.dialog")

        @include("watch.gogoanime")

    </div>

@endsection



@section("head")

    <script src="{{config("app.url")}}/vtt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@1.4.14/dist/hls.min.js"></script>
    <style>

        @media only screen and (max-width: 1400px) {
            .f-cont-video {
                grid-template-columns: 1fr !important;
            }
        }

        @media only screen and (max-width: 1200px) {
            .s-cont-video {
                grid-template-columns: 1fr !important;

            }

            .s-cont-video > div:first-child {
                order: 2;
            }

            #video {
                margin-left: -1.5rem;
                margin-top: -1.5rem;

                width: calc(100% + 3rem);

                border-radius: 0 !important;
            }

            #bottombuttons {
                margin-left: -1.5rem;
                margin-top: -1.5rem;

                width: calc(100% + 3rem);

                border-radius: 0 !important;
            }
        }

        @media only screen and (max-width: 600px) {
            #padderoutside {
                padding: .5rem !important;
            }

            #video {
                margin-left: -.5rem;
                margin-top: -.5rem;

                width: calc(100% + 1rem);
            }

            #bottombuttons {
                margin-left: -.5rem;
                margin-top: -.5rem;

                width: calc(100% + 1rem);
            }
        }

    </style>
    <script data-label="Main javascript">

        let dub = (localStorage.getItem("dubbedvideo") === "true") ? true : false;
        let autoSkip = (localStorage.getItem("autoskip") === "false") ? false : true;
        let videoserver = localStorage.getItem("videoserver") ?? "vidstreaming";
        let cors = true;
        let gogoProvider = false;

        let anime = {episodes: JSON.parse("{{ $epstring }}".replace(/&quot;/g, '"')) };
        let malID;

        let episodeId = "";
        let episodeIndex = {{ $history }};
        let episodeSkipTimes = [];

        let subtitleLang = localStorage.getItem("subtitleslang") || "English";
        let subtitles = [];
        let subtitlesEnabled = localStorage.getItem("subtitlesenabled") === "true" ? true : false;
        // let subtitlesEnabled = true;

        let hlsStream;

        let fillScreen = localStorage.getItem("fillscreen") === "true" ? true : false;

        let video;

        async function loadEpId(i, id) {
            episodeId = id;
            episodeIndex = i;
            episodeSkipTimes = [];
            subtitles = [];
            $("#video #settings #subtitles").html("");
            $("#video #settings #quality").html("");
            $("#video #track").html("");
            $('#video video track[kind="subtitles"]').remove();
            $("#video #loadercircle").removeClass("d-none");
            $("#video #errorcircle").addClass("d-none");
            $("#video #wanimelogo").addClass("d-none");

            fetch(`{{ $_ENV["APP_URL"] }}/api/episode/{{ $anime["anime"]["info"]["id"] }}`, {
                method: "PUT",
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    "episode": i
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            });

            let response;
            try {
                response = await (await fetch("{{config("app.api_url")}}/anime/servers?episodeId="+id)).json();
            } catch (error) {
                $("#video #loadercircle").addClass("d-none");
                $("#video #errorcircle").removeClass("d-none");
                $("#errormodal .modal-footer #errorcode").html(`watch.001`);
                (new bootstrap.Modal('#errormodal')).show();
                return;
            }

            if (dub && response["dub"].length === 0 && response["sub"].length > 0) {dub = false;} else
            if (!dub && response["sub"].length === 0 && response["dub"].length > 0) {dub = true;} else
            if (response["sub"].length === 0 && response["dub"].length === 0) {
                $("#video #loadercircle").addClass("d-none");
                $("#video #errorcircle").removeClass("d-none");
                $("#errormodal .modal-footer #errorcode").html(`watch.002`);
                (new bootstrap.Modal('#errormodal')).show();
                return;
            }
            let exist = response[dub ? "dub": "sub"].some(obj => obj.serverName === videoserver);
            if (!exist) { videoserver = response[dub ? "dub" : "sub"][0].serverName; }

            loadServer(videoserver, dub ? "dub": "sub");
            renderServers(response);
        }

        loadEpId({{ $history }}, "{{ $episodes["episodes"][$history]["episodeId"] }}");

        async function loadServer(server, category="sub") {

            $("#video #loadercircle").removeClass("d-none");
            $("#video #errorcircle").addClass("d-none");
            $("#video #wanimelogo").addClass("d-none");

            let response;
            try {
                // response = await (await fetch(`{{config("app.api_url")}}/anime/episode-srcs?id=${episodeId}&server=${server}&category=${category}`)).json();
                response = await (await fetch(`{{config("app.api_url")}}/anime/episode-srcs?id=${episodeId}&category=${category}`)).json();
                malID = response.malID;
            } catch (error) {
                $("#video #loadercircle").addClass("d-none");
                $("#video #errorcircle").removeClass("d-none");
                $("#errormodal .modal-footer #errorcode").html(`watch.003`);
                (new bootstrap.Modal('#errormodal')).show();
                return;
            }

            if (response.status === 500) {
                $("#video #loadercircle").addClass("d-none");
                $("#video #errorcircle").removeClass("d-none");
                // $("#servererrormodal .modal-footer #errorcode").html(`watch.004`);
                // $("#servererrormodal .modal-body #errorpastecode").html(response.message);
                // (new bootstrap.Modal('#servererrormodal')).show();
                initGogo();
                return;
            }

            let url;
            try {
                url = response.sources.filter(obj => obj.type === "hls")[0].url;
                // url = "https://demo.unified-streaming.com/k8s/features/stable/video/tears-of-steel/tears-of-steel.ism/.m3u8";
            } catch (error) {
                $("#video #loadercircle").addClass("d-none");
                $("#video #errorcircle").removeClass("d-none");
                $("#errormodal .modal-footer #errorcode").html(`watch.004`);
                (new bootstrap.Modal('#errormodal')).show();
                return;
            }

            $("#video #settings #subtitles").html("");
            if (response.tracks.filter(obj => obj.kind === "captions").length > 0) {

                response.tracks.found = false;

                let defaultSubtitle = response.tracks.filter(obj => obj.lang === subtitleLang)[0];
                if (!defaultSubtitle) subtitlesEnabled = false;
                // else $("#video #settings #subtitles").append(`<div class="bg-body-tertiary rounded p-2 d-flex align-items-center gap-2" role="button" onclick="changeSubtitle(this, '${defaultSubtitle.lang}','${defaultSubtitle.url}')"><input class="form-check-input m-0" type="radio" name="subtitlesRadioGroup" disabled ${subtitlesEnabled ? "checked" : ""}><p class="m-0">${defaultSubtitle.lang}</p><i class="fi fi-sr-subtitles ms-auto"></i></div>`);

                $("#video #settings #subtitles").append(`<div class="bg-body-tertiary rounded p-2 d-flex align-items-center gap-2" role="button" onclick="changeSubtitle(this)"><input class="form-check-input m-0" type="radio" name="subtitlesRadioGroup" disabled ${subtitlesEnabled || !defaultSubtitle ? "" : "checked"}><p class="m-0">Disabled</p><i class="fi fi-sr-subtitles ms-auto"></i></div>`);

                for (let i = 0; i < response.tracks.length; i++) {
                    const subtitle = response.tracks[i];
                    let html;

                    if (defaultSubtitle && subtitle.label === defaultSubtitle.label) {
                        html = `<div class="bg-body-tertiary rounded p-2 d-flex align-items-center gap-2" role="button" onclick="changeSubtitle(this, '${defaultSubtitle.label}','${defaultSubtitle.file}')"><input class="form-check-input m-0" type="radio" name="subtitlesRadioGroup" disabled ${subtitlesEnabled ? "checked" : ""}><p class="m-0">${defaultSubtitle.label}</p><i class="fi fi-sr-subtitles ms-auto"></i></div>`;
                    } else if (((defaultSubtitle && subtitle.lang !== defaultSubtitle.lang) || !defaultSubtitle)) {
                        html = `<div class="bg-body-tertiary rounded p-2 d-flex align-items-center gap-2" role="button" onclick="changeSubtitle(this, '${subtitle.label}','${subtitle.file}')"><input class="form-check-input m-0" type="radio" name="subtitlesRadioGroup" disabled><p class="m-0">${subtitle.label}</p><i class="fi fi-sr-subtitles ms-auto"></i></div>`;
                    }

                    $("#video #settings #subtitles").append(html);
                }

                if (subtitlesEnabled && defaultSubtitle) loadSubtitles(defaultSubtitle.url);

            }

            loadVideo(url);
        }

        async function loadVideo(url) {
            if (Hls.isSupported()) {
                hlsStream = new Hls();
                hlsStream.on(Hls.Events.ERROR, function (event, data) {
                    console.log("Video error", event, data);
                    $("#video #loadercircle").addClass("d-none");
                    $("#video #errorcircle").removeClass("d-none");
                    $("#errormodal .modal-footer #errorcode").html(`watch.006`);
                    (new bootstrap.Modal('#errormodal')).show();
                    return;
                });
                hlsStream.loadSource(cors ? `{{config("app.cors_url")}}${url}` : url);
                hlsStream.attachMedia(video);
                hlsStream.on(Hls.Events.MANIFEST_PARSED, function() {
                    $("#video #loadercircle").addClass("d-none");
                    $("#video #wanimelogo").removeClass("d-none");
                    $("#video").addClass("playing");

                    setTimeout(() => {
                        $("#video #wanimelogo").addClass("d-none");
                        video.play();
                    }, 3000);

                    let qualities = hlsStream.levels;
                    let selectedQuality = hlsStream.currentLevel;
                    console.log((selectedQuality));
                    $("#video #settings #quality").append(`<div class="bg-body-tertiary rounded p-2 d-flex align-items-center gap-2" role="button" onclick="changeQuality(this)"><input class="form-check-input m-0" type="radio" name="qualityRadioGroup" disabled ${selectedQuality === -1 ? "checked" : ""}><p class="m-0">Auto</p></div>`);
                    for (let i = 0; i < qualities.length; i++) {
                        $("#video #settings #quality").append(`<div class="bg-body-tertiary rounded p-2 d-flex align-items-center gap-2" role="button" onclick="changeQuality(this, ${i})"><input class="form-check-input m-0" type="radio" name="qualityRadioGroup" disabled ${selectedQuality === i ? "checked" : ""}><p class="m-0">${qualities[i].height}p</p></div>`);
                    }

                });
            } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                video.src = url;
            }
            setTimeout(() => {
                loadSkipTimes();
            }, 1000);
        }

        async function loadSkipTimes() {
            let skipTimes = {};
            if (malID) {
                try {
                    skipTimes = await (await fetch(`https://api.aniskip.com/v2/skip-times/${malID}/${episodeIndex + 1}?types=op&types=ed&types=mixed-op&types=mixed-ed&episodeLength=0`)).json();
                } catch (error) {console.error("Error while fetching skip times.", error);}
            }
            if (skipTimes.found) {
                try {
                    let duration = video.duration;
                    let track = document.querySelector("#video #track");
                    for (let i = 0; i < skipTimes.results.length; i++) {
                        let skipTimeElem = document.createElement("div");
                        skipTimeElem.classList.add("skiptime");
                        skipTimeElem.style.left = `${100 / duration * skipTimes.results[i].interval.startTime}%`;
                        skipTimeElem.style.width = `${100 / duration * (skipTimes.results[i].interval.endTime - skipTimes.results[i].interval.startTime)}%`;
                        skipTimeElem.style.backgroundColor = skipTimes.results[i].skipType === "op" ? "green" : (skipTimes.results[i].skipType === "ed" ? "red" : "blue");
                        track.appendChild(skipTimeElem);
    
                        skipTimes.results[i].interval.skipType = skipTimes.results[i].skipType;
    
                        episodeSkipTimes.push(skipTimes.results[i].interval);
                    }
                } catch (error) {console.error("Error while loading the skiptimes.", error);}
            }
        }

        let vttParser = new WebVTT.Parser(window, WebVTT.StringDecoder());
        async function loadSubtitles(url) {
            let cues = [],
                regions = [];
            vttParser.oncue = function(cue) {
                cues.push(cue);
            };
            vttParser.onregion = function(region) {
                regions.push(region);
            }
            vttParser.parse(await (await fetch(url)).text());
            vttParser.flush();

            let div = WebVTT.convertCueToDOMTree(window, cues[0].text);
            let divs = WebVTT.processCues(window, cues, document.getElementById("overlay"));

            subtitles = cues;
        }
    </script>
    <script data-label="Voting box javascript">

        let voteStars = {{ $stars["selected"] }};

        function updateStarCss(elem, hover, index) {
            let jElem = $(elem);
            let children = elem.parentNode.querySelectorAll("button");
            jElem.parent().children().children().addClass("text-body-secondary");
            jElem.parent().children().children().removeClass("fi-sr-star");
            jElem.parent().children().children().addClass("fi-rr-star");
            if (hover) {
                for (let i = 0; i < index; i++) {
                    children[i].querySelector("i").classList.remove("text-body-secondary", "fi-rr-star");
                    children[i].querySelector("i").classList.add("fi-sr-star");
                }
            } else {
                for (let i = 0; i < voteStars; i++) {
                    children[i].querySelector("i").classList.remove("fi-rr-star");
                    children[i].querySelector("i").classList.add("fi-sr-star");
                }
            }
        }

        function voteStarClick(index) {
            fetch(`{{config("app.url")}}/api/star`, {
                method: "POST",
                body: JSON.stringify({
                    "_token" : "{{ csrf_token() }}",
                    "stars": index,
                    "id": "{{ $anime["anime"]["info"]["id"] }}",
                    "title": "{{ $anime["anime"]["info"]["name"] }}",
                    "poster": "{{ $anime["anime"]["info"]["poster"] }}"
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            }).then(r => r.json())
            .then(r => {
                $("[data-anime-vote-stars]").text(Number(r.stars));
            });

            voteStars = index;
            updateStarCss(document.querySelector("#voting button"), false, 1);
        }

    </script>
    @yield("head.episodes")
    @yield("head.video")
    @yield("head.servers")
    @yield("head.gogoanime")
@endsection
