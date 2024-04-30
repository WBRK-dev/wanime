<div>

    <div id="video" class="position-relative rounded overflow-hidden" style="isolation: isolate;">
        <video class="d-block w-100 bg-black" style="aspect-ratio: 16/9;" muted>
            <track kind="captions">

            
        </video>

        <div class="position-absolute top-0 start-0 w-100">
            <p class="m-2 fs-5 fw-bold" id="episodetitle"></p>
        </div>
    
        <div class="position-absolute top-0 start-0 w-100 h-100">
            <div id="backcontrols" class="position-absolute bottom-0 start-0 w-100" style="height: 200px;"></div>
        </div>

        <div id="videosubtitles" class="d-flex flex-column align-items-center position-absolute start-50 translate-middle-x" style="max-width: 100%; bottom: calc(52px + .5rem);">
            
        </div>

        <div id="loadercircle"></div>
        <div id="errorcircle" class="d-none z-1" onclick="this.classList.add('d-none')"><i class="fi fi-sr-cross"></i></div>
        <div class="d-none" id="wanimelogo">
            <div id="text">
                <p>WAnime</p>
                <p id="backup" class="d-none">Backup server</p>
            </div>
        </div>

        <div id="settings" class="bg-body-secondary position-absolute rounded z-2 user-select-none d-flex flex-column d-none" style="right: .5rem; bottom: calc(52px + .5rem); height: min(300px, calc(100% - 52px - 1rem)); width: 250px;" data-cancel-search>
            <div class="d-flex align-items-center border-bottom py-2 px-3 ps-2 gap-2" id="header"><i class="fi fi-sr-angle-left" role="button" onclick="openSettingTab()"></i><p class="m-0">Settings</p><button class="ms-auto p-0 m-0 bg-transparent border-0" onclick="toggleSettings()"><i class="fi fi-sr-cross"></i></button></div>
            <div class="p-2 overflow-auto d-flex flex-column gap-2 flex-grow-1" id="body" data-settings-tab>
                <div class="bg-body-tertiary rounded p-2 d-flex align-items-center" role="button" onclick="openSettingTab('quality')"><p class="m-0">Quality</p><i class="fi fi-sr-arrow-right ms-auto"></i></div>
                <div class="bg-body-tertiary rounded p-2 d-flex align-items-center" role="button" onclick="openSettingTab('subtitles')"><p class="m-0">Subtitles</p><i class="fi fi-sr-arrow-right ms-auto"></i></div>
                <div class="bg-body-tertiary rounded p-2 d-flex align-items-center" role="button" onclick="openSettingTab('corsproviders')"><p class="m-0">Cors Providers</p><i class="fi fi-sr-arrow-right ms-auto"></i></div>
                <div class="bg-body-tertiary rounded p-2 d-flex align-items-center" role="button" onclick="settingUpdate('fillscreen', undefined, 'switch', this)" id="fillscreen"><p class="m-0">Fill Screen</p><p class="m-0 ms-auto" id="label">Off</p></div>
            </div>
            <div class="p-2 overflow-auto d-flex flex-column gap-2 flex-grow-1 d-none" id="subtitles" data-settings-tab></div>
            <div class="p-2 overflow-auto d-flex flex-column gap-2 flex-grow-1 d-none" id="quality" data-settings-tab></div>
            <div class="p-2 overflow-auto d-flex flex-column gap-2 flex-grow-1 d-none" id="corsproviders" data-settings-tab></div>
        </div>
    
        <div id="controls">
    
            <div id="track-wrapper" data-cancel-search><div id="track" class="position-absolute"></div><div style="display: none;" id="track-scrub-time">00:00</div></div>
    
            <div id="buttons" class="position-absolute bottom-0 start-0 d-flex flex-wrap p-2 w-100" style="box-sizing: border-box;">
                <div id="play" class="p-2 fi-switch" onclick="togglePlay()" data-cancel-search><i class="fi fi-16 fi-sr-play" id="disabled"></i><i class="fi fi-16 fi-sr-pause" id="enabled"></i></div>
                <div id="mute" class="p-2 fi-switch active" onclick="toggleMute()" data-cancel-search><i class="fi fi-16 fi-sr-volume" id="disabled"></i><i class="fi fi-16 fi-sr-volume-mute" id="enabled"></i></div>
    
                <p class="my-auto mx-1" id="time" data-cancel-search><span id="current">00:00</span>/<span id="total">00:00</span></p>

                <div class="ms-auto d-flex" data-cancel-search>
                    
                    <div class="p-2 fi-switch" title="Download Episode" onclick="downloadHandler()"><i class="fi fi-16 fi-sr-download"></i></div>
                    <div class="p-2 fi-switch" onclick="skip(-30)"><i class="fi fi-16 fi-sr-angle-double-small-left"></i></div>
                    <div class="p-2 fi-switch" onclick="skip(30)"><i class="fi fi-16 fi-sr-angle-double-small-right"></i></div>
                    <div class="p-2 fi-switch" onclick="toggleSettings()"><i class="fi fi-16 fi-sr-settings"></i></div>
                    <div id="fullscreen" class="p-2 fi-switch" onclick="toggleFullscreen()"><i class="fi fi-16 fi-sr-expand" id="disabled"></i><i class="fi fi-16 fi-sr-compress" id="enabled"></i></div>
    
                </div>
            </div>
        </div>

        <div class="position-absolute top-0 start-0 w-100 h-100 pe-none user-select-none" id="overlays"></div>
    </div>

    <div id="bottombuttons" class="d-flex flex-wrap align-items-center rounded-bottom" style="background-color: #000; margin-top: -20px; padding-top: 20px;">
        <button class="btn ms-2" onclick="tryPrevEp()">Prev</button>
        <button class="btn" onclick="tryNextEp()">Next</button>

        <div class="d-flex flex-wrap align-items-center ms-auto justify-content-end">
            <button class="btn ms-auto" id="autoskip">Skip OP&ED <span class="text-success">On</span></button>
            @auth
                <div class="watchlist-dropdown">
                    <button class="btn"><span>{{ $watchlist["label"] }}</span><i class="fi fi-sr-caret-down"></i></button>
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
    </div>

</div>


@section("head.video")
    
<script src="{{config("app.url")}}/wanime-style-1/modules-js/watchlist-dropdown.js"></script>
<script>

    function watchlistStatusUpdate(state) {
        fetch(`{{ config("app.url") }}/api/watchlist/{{ $anime["anime"]["info"]["id"] }}`, {
            method: "PUT",
            body: JSON.stringify({
                "_token": "{{ csrf_token() }}",
                "status": state,
                "anime": {
                    "title": "{{ $anime["anime"]["info"]["name"] }}",
                    "image": "{{ $anime["anime"]["info"]["poster"] }}"
                }
            }),
            headers: {
                "Content-Type": "application/json"
            }
        });
    }

</script>
<script>

    let trackUpdateInterval;
    let skipTimesInterval;
    let SubtitleUpdateInterval;

    window.onload = () => {
        video = document.querySelector("video");

        video.addEventListener("ended", () => {
            clearInterval(skipTimesInterval);
            tryNextEp();
        });

        video.addEventListener("play", () => {
            trackUpdateInterval = setInterval(updateTrack, 1000);
            SubtitleUpdateInterval = setInterval(updateSubtitles, 200);
            if (autoSkip) skipTimesInterval = setInterval(checkSkipTimes, 1000);
            $("#video #controls #buttons #play").addClass("active");
            $("#video").addClass("playing");
        });

        video.addEventListener("pause", () => {
            clearInterval(trackUpdateInterval);
            clearInterval(skipTimesInterval);
            clearInterval(SubtitleUpdateInterval);
            $("#video #controls #buttons #play").removeClass("active");
            $("#video").removeClass("playing");
            if (!tracking) updateTrack();
        });

        $("#video #track-wrapper").on("pointerdown", (e) => {
            tracking = true;
            let pos = document.querySelector("#video #track-wrapper").getBoundingClientRect();
            trackPos.x = pos.x;
            trackPos.width = Math.round(pos.width);
            video.pause();
            $("#video #track-wrapper #track-scrub-time").css("display", "");
            updateTrackMouseMove(e);
        });

        $("body").on("pointerup", (e) => {
            if (tracking) {

                let width = 0;
                width = (100 / trackPos.width * (e.originalEvent.x - trackPos.x));
                if (width < 0) {width = 0};
                if (width > 100) {width = 100};
                video.currentTime = video.duration * (width / 100);

                $("#video #track-wrapper #track-scrub-time").css("display", "none");

                video.play();
                updateTrack();
            }
            tracking = false;
        });

        $("body").on("pointermove", (e) => {
            if (tracking) {
                updateTrackMouseMove(e);
            }
        });

        $(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange', function(e) {
            if (checkFullscreen()) {
                $("#controls #buttons #fullscreen").addClass("active");
            } else {
                $("#controls #buttons #fullscreen").removeClass("active");
            }
        });

        let activeMouseTimeout; let activeMouse = false;
        $("#video").on("mousemove", function () {
            $(this).addClass("mouse");
            if (!activeMouse) {
                setTimeout(() => {
                    updateTrack();
                    activeMouse = true;
                }, 50);
            }
            clearTimeout(activeMouseTimeout);
            activeMouseTimeout = setTimeout(() => {
                $(this).removeClass("mouse");
                activeMouse = false;
            }, 3000);
        });


        $("#video").on("mousedown", function(e) {
            if (!activeMouse) {return;}
            let target = e.target;
            let searching = true;
            while (searching) {
                if ($(target).attr("data-cancel-search") !== undefined) {
                    searching = false;
                } else if (target.id === "video") {
                    togglePlay();
                    searching = false;
                } else {
                    target = target.parentNode;
                }
            }
        });

        if (!autoSkip) {
            $("#bottombuttons #autoskip span").removeClass("text-success");
            $("#bottombuttons #autoskip span").addClass("text-danger");
            $("#bottombuttons #autoskip span").text("Off");
        }

        $("#bottombuttons #autoskip").click(function() {
            if (autoSkip) {
                autoSkip = false;
                clearInterval(skipTimesInterval);
                $(this).children("span").removeClass("text-success");
                $(this).children("span").addClass("text-danger");
                $(this).children("span").text("Off");
            } else {
                autoSkip = true;
                skipTimesInterval = setInterval(checkSkipTimes, 1000);
                $(this).children("span").removeClass("text-danger");
                $(this).children("span").addClass("text-success");
                $(this).children("span").text("On");
            }
            localStorage.setItem("autoskip", autoSkip);
        });


        // Init settings
        if (fillScreen) {
            $("#video video").addClass("fillscreen");
            $("#video #settings #fillscreen #label").html("On");
        }

        let corsProvidersKeys = Object.keys(corsProviders);
        $("#video #settings #corsproviders").append(`<div class="bg-body-tertiary rounded p-2 d-flex align-items-center gap-2" role="button" onclick="changeCorsProvider(this, 'disabled')"><input class="form-check-input m-0" type="radio" name="subtitlesRadioGroup" disabled ${!corsProvider || corsProvider === "disabled" ? "checked" : ""}><p class="m-0">Disabled</p><i class="fi fi-sr-subtitles ms-auto"></i></div>`);
        for (let i = 0; i < corsProvidersKeys.length; i++) {
            $("#video #settings #corsproviders").append(`<div class="bg-body-tertiary rounded p-2 d-flex align-items-center gap-2" role="button" onclick="changeCorsProvider(this, '${corsProvidersKeys[i]}')"><input class="form-check-input m-0" type="radio" name="subtitlesRadioGroup" disabled ${corsProvider === corsProvidersKeys[i] ? "checked" : ""}><p class="m-0">${corsProvidersKeys[i]}</p><i class="fi fi-sr-subtitles ms-auto"></i></div>`);
        }
        corsProvidersKeys = undefined;
    }


    function updateTrack() {
        if (!$("#video").hasClass("mouse") && $("#video").hasClass("playing")) {return;}

        let width = 100 / video.duration * video.currentTime;
        $("#video #track").css("--width", Math.round(width * 10000) / 10000+"%");

        let currentHours = Math.floor(video.currentTime / 3600);
        let currentMinutes = Math.round(Math.floor(video.currentTime / 60) % 60);
        let currentSeconds = Math.round(video.currentTime % 60);
        let totalHours = Math.floor((video.duration || 0) / 3600);
        let totalMinutes = Math.round(Math.floor((video.duration || 0) / 60) % 60);
        let totalSeconds = Math.round((video.duration || 0) % 60);

        if (currentSeconds === 60) {currentSeconds = 0; currentMinutes++;}
        if (currentMinutes === 60) {currentMinutes = 0; currentHours++;}
        if (totalSeconds === 60) {totalSeconds = 0; totalMinutes++;}
        if (totalMinutes === 60) {totalMinutes = 0; totalHours++;}

        currentHours = (currentHours < 10) ? `0${currentHours}` : currentHours;
        currentMinutes = (currentMinutes < 10) ? `0${currentMinutes}` : currentMinutes;
        currentSeconds = (currentSeconds < 10) ? `0${currentSeconds}` : currentSeconds;

        totalHours = (totalHours < 10 && totalHours !== 0) ? `0${totalHours}` : totalHours;
        totalMinutes = (totalMinutes < 10) ? `0${totalMinutes}` : totalMinutes;
        totalSeconds = (totalSeconds < 10) ? `0${totalSeconds}` : totalSeconds;

        $("#video #time #current").text(`${(totalHours !== 0) ? `${currentHours}:` : ""}${currentMinutes}:${currentSeconds}`);
        $("#video #time #total").text(`${(totalHours !== 0) ? `${totalHours}:` : ""}${totalMinutes}:${totalSeconds}`);

    }

    function checkSkipTimes() {
        let time = video.currentTime;
        for (let i = 0; i < episodeSkipTimes.length; i++) {
            const times = episodeSkipTimes[i];
            if (times.startTime < time && times.endTime > time) {
                video.currentTime = times.endTime;
                
                let skipOverlay = document.createElement("div");
                skipOverlay.classList.add("overlay");
                skipOverlay.innerHTML = `<i class="fi fi-sr-angle-double-small-right"></i><p class="m-0">Skipped ${times.skipType.toUpperCase()}</p>`;
                document.querySelector("#video #overlays").appendChild(skipOverlay);
            }
        }
    }

    function updateSubtitles() {
        if (!subtitlesEnabled) return;
        let subtitleString = "", videoTime = video.currentTime;
        let activeSubtitles = subtitles.filter(obj => obj.startTime < videoTime && obj.endTime > videoTime);
        for (let i = 0; i < activeSubtitles.length; i++) {
            subtitleString += `<p class="m-0 bg-black p-2 rounded" style="--bs-bg-opacity: .5;">${activeSubtitles[i].text}</p>`;
        }
        $("#video #videosubtitles").html(subtitleString);
    }

    let tracking = false;
    let trackPos = {x:0,width:0};
    function updateTrackMouseMove(e) {

        let width = 0;
        width = (100 / trackPos.width * (e.originalEvent.x - trackPos.x));
        if (width < 0) {width = 0};
        if (width > 100) {width = 100};
        $("#video #track").css("--width", Math.round(width * 10000) / 10000+"%");

        let videoScrubTime = (video.duration || 0) / 100 * width;

        let currentHours = Math.floor(videoScrubTime / 3600);
        let currentMinutes = Math.round(Math.floor(videoScrubTime / 60) % 60);
        let currentSeconds = Math.round(videoScrubTime % 60);
        let totalHours = Math.floor((video.duration || 0) / 3600);
        let totalMinutes = Math.round(Math.floor((video.duration || 0) / 60) % 60);
        let totalSeconds = Math.round((video.duration || 0) % 60);

        if (currentSeconds === 60) {currentSeconds = 0; currentMinutes++;}
        if (currentMinutes === 60) {currentMinutes = 0; currentHours++;}
        if (totalSeconds === 60) {totalSeconds = 0; totalMinutes++;}
        if (totalMinutes === 60) {totalMinutes = 0; totalHours++;}

        currentHours = (currentHours < 10) ? `0${currentHours}` : currentHours;
        currentMinutes = (currentMinutes < 10) ? `0${currentMinutes}` : currentMinutes;
        currentSeconds = (currentSeconds < 10) ? `0${currentSeconds}` : currentSeconds;

        $("#video #track-wrapper #track-scrub-time").css("left", `${ Math.round(width * 10000) / 10000 }%`);
        $("#video #track-wrapper #track-scrub-time").text(`${(totalHours !== 0) ? `${currentHours}:` : ""}${currentMinutes}:${currentSeconds}`);

    }

    function togglePlay() {
        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    }

    function toggleMute() {
        if (video.muted) {
            video.muted = false;
            $("#video #controls #buttons #mute").removeClass("active");
        } else {
            video.muted = true;
            $("#video #controls #buttons #mute").addClass("active");
        }
    }

    function checkFullscreen() {
        if (document.fullscreenElement || document.webkitFullscreenElement ||
        document.mozFullScreenElement) {
            return true;
        } else {
            return false;
        }
    }

    function toggleFullscreen() {
        if (checkFullscreen()) {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { /* Safari */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE11 */
                document.msExitFullscreen();
            }
        } else {
            let elem = document.querySelector("#video");
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) { /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE11 */
                elem.msRequestFullscreen();
            }
        }
    }

    function skip(amount) {
        video.currentTime += amount;
    }

    function tryNextEp() {
        if (episodeIndex + 1 < anime.episodes.episodes.length) {
            epClick(episodeIndex + 1, anime.episodes.episodes[episodeIndex + 1].episodeId);
        }
    }

    function tryPrevEp() {
        if (episodeIndex - 1 >= 0) {
            epClick(episodeIndex - 1, anime.episodes.episodes[episodeIndex - 1].episodeId);
        }
    }

    function apiCall(state) {
            fetch(`{{ $_ENV["APP_URL"] }}/api/watchlist/{{ $anime["anime"]["info"]["id"] }}`, {
                method: "PUT",
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    "status": state,
                    "anime": {
                        "title": "{{ $anime["anime"]["info"]["name"] }}",
                        "image": "{{ $anime["anime"]["info"]["poster"] }}"
                    }
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            });
        }

        function dropdownHandler(elem, state) {

            $(elem).parent().parent().children().children().removeClass("active");
            $(elem).parent().parent().children().children().removeClass("disabled");
            $(elem).parent().parent().parent().find("button").first().text($(elem).text());
            $(elem).addClass("active");

            apiCall(state);

        }

        function removeButton(elem) {

            $(elem).parent().parent().children().children().removeClass("active");
            $(elem).parent().parent().parent().find("button").first().text("WatchList");
            $(elem).addClass("disabled")

            apiCall("remove");

        }

        function changeSubtitle(elem, lang, url) {
            if (lang) {
                subtitlesEnabled = true;
                localStorage.setItem("subtitleslang", lang);
                loadSubtitles(url);
            } else {
                subtitlesEnabled = false;
                subtitles = [];
            }
            $(elem).children("input").prop("checked", true);
            localStorage.setItem("subtitlesenabled", subtitlesEnabled);
            $("#video #videosubtitles").html("");
        }

        function changeQuality(elem, q) {
            if (q) {
                localStorage.setItem("videoquality", q);
                hlsStream.loadLevel = q;
            } else {
                localStorage.setItem("videoquality", "auto");
                hlsStream.loadLevel = -1;
            }
            $(elem).children("input").prop("checked", true);
        }

        function changeCorsProvider(elem, provider) {
            localStorage.setItem("corsprovider", provider);
            corsProvider = provider;
            loadVideo(loadedUrl);
            $(elem).children("input").prop("checked", true);
        }

        function toggleSettings() {
            if ($("#video #settings").hasClass("d-none")) {
                $("#video #settings").removeClass("d-none");
                openSettingTab();
            } else {
                $("#video #settings").addClass("d-none");
            }
        }

        function openSettingTab(tab) {
            if (!tab) {
                $("#video #settings [data-settings-tab]").addClass("d-none");
                $("#video #settings #body").removeClass("d-none");
            } else {
                $("#video #settings [data-settings-tab]").addClass("d-none");
                $("#video #settings #"+tab).removeClass("d-none");
            }
        }

        function settingUpdate(setting, value, rendertype, elem) {
            if (elem) jElem = $(elem);
            let status;
            
            if (rendertype === "switch") {
                if (elem.querySelector("#label").innerHTML === "Off") {elem.querySelector("#label").innerHTML = "On"; status = true;}
                else {elem.querySelector("#label").innerHTML = "Off"; status = false;}
            }

            if (setting === "fillscreen" && status) {
                $("#video video").addClass("fillscreen");
                localStorage.setItem("fillscreen", status);
            } else if (setting === "fillscreen" && !status) {
                $("#video video").removeClass("fillscreen");
                localStorage.setItem("fillscreen", status);
            }
        }

</script>

<style>

    #video:fullscreen {border-radius: 0 !important;}

    #video:fullscreen video {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
    }

    #video:fullscreen video.fillscreen {
        top: 50%; left: 0;
        width: 100%; height: auto;
        transform: translateY(-50%);
    }

    #video.playing:not(.mouse) {
        cursor: none;
    }

    #video #track-wrapper {
        width: calc(100% - 2rem);
        height: 12px;
        box-sizing: border-box;

        left: 1rem;
        bottom: 44px;

        position: absolute;
        z-index: 1;
    }

    #video #track {
        width: 100%;
        height: 4px;
        background-color: #5f5f5f;
        box-sizing: border-box;

        left: 0; top: 50%;
        transform: translateY(-50%);

        position: relative;
        transition: height 200ms;
    }
    #video #track-wrapper:hover #track, #video #track-wrapper:active #track, #video #track-wrapper:focus #track {
        height: 16px;
    }
    #video #track::before {
        content: "";

        position: absolute;
        top: 0; left: 0;
        width: var(--width, 0%);
        height: 100%;

        background-color: #fff;
    }

    #video #track .skiptime {
        position: absolute;
        height: 100%;
    }

    #video #track-wrapper #track-scrub-time {
        padding: .25rem .5rem;
        background-color: #00000057;
        backdrop-filter: blur(2px);
        border-radius: .5rem;

        position: absolute;
        bottom: calc(100% + .5rem);
        left: 50%;
        transform: translateX(-50%);
    }

    #video #controls {
        position: absolute;
        width: 100%; height: 100%;
        top: 0; left: 0;

        opacity: 0;
        transition: opacity 250ms;
    }
    #video.mouse #controls {opacity: 1;}
    #video:not(.playing) #controls {opacity: 1;}

    #video #controls i {color: #ffffffb6;}
    #video #controls .fi-switch:hover i {color: #ffffff;}
    #video #controls .fi-switch {cursor: pointer;}

    #video #backcontrols {
        opacity: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.5) 50%, rgba(0,0,0,0) 100%);

        transition: opacity 250ms;
    }
    #video.mouse #backcontrols {opacity: 1;}
    #video:not(.playing) #backcontrols {opacity: 1;}

    #video #loadercircle {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);

        height: 20%;
        max-height: 150px;
        aspect-ratio: 1;

        border: 4px solid #fff;
        border-radius: 50%;
        border-bottom: 4px solid transparent;
        border-left: 4px solid transparent;

        animation: loadercircle 1s infinite linear;
    }

    @keyframes loadercircle {
        0% {transform: translate(-50%, -50%) rotateZ(0deg);}
        100% {transform: translate(-50%, -50%) rotateZ(360deg);}
    }

    #video #errorcircle {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);

        height: 70px;
        aspect-ratio: 1;

        border-radius: 50%;
        background-color: var(--bs-danger);

        display: grid; place-items: center;
        font-size: 24px;
    }

    #video #wanimelogo {
        position: absolute;
        top: 0; left: 0;
        /* transform: translateY(-50%); */

        width: 100%;
        height: 100%;
        background-color: #000;

        display: grid;
        place-items: center;

        overflow: hidden;
    }
    #video #wanimelogo #text {
        margin: 0 !important;
        font-weight: 700;
        font-size: 48px;
        position: relative;

        animation: wanimelogo 1s forwards;
    }

    @keyframes wanimelogo {
        0%{opacity: 0;}
        100%{opacity: 1;}
    }
    
    #video #wanimelogo p {margin: 0;}
    #video #wanimelogo p#backup {
        font-size: 18px;
        margin-top: -10px;
    }

    #video #wanimelogo #text::after {
        content: "";

        position: absolute;
        bottom: 200%; left: -50%;

        width: 200%; height: 200%;
        transform: rotateZ(-20deg);

        background-color: #000;

        animation: wanimelogoafter 200ms 2800ms forwards linear;
    }

    @keyframes wanimelogoafter {
        0%{bottom: 200%;}
        100%{bottom: -50%;}
    }

</style>

@endsection