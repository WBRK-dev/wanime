<script>

    import hlsJs from "https://cdn.jsdelivr.net/npm/hls.js@1.5.13/+esm";
    import VttJs from 'https://cdn.jsdelivr.net/npm/videojs-vtt.js@0.15.5/+esm';
    import clickOutside from "../../Utils/ClickOutside";

    export let src;
    export let tracks = [];
    export let skipTimes = [];

    $: src, loadSource();
    $: tracks, onTrackArrayChange();

    const parser = new VttJs.WebVTT.Parser(window, VttJs.WebVTT.StringDecoder());

    let hlsStream;
    let videoWrapperElem;
    let videoElem;
    let videoPaused;
    let videoMuted = true;
    let videoCurrentTime;
    let videoTotalTime;
    let videoBufferedTime = 0;

    let subtitleCues = [];
    parser.oncue = function(cue) { subtitleCues.push(cue); };
    let subtitleTextBlocks = [];
    let selectedSubtitleFile;
    let selectedSubtitleLabel = localStorage.getItem("wanime-video-subtitle-label") || "";
    let subtitleScale = localStorage.getItem("wanime-video-subtitle-scale") || 100;
    let subtitleFontSize = localStorage.getItem("wanime-video-subtitle-font-size") || 16;
    let subtitleBottomOffset = localStorage.getItem("wanime-video-subtitle-bottom-offset") || 16;
    let subtitleMaxWidth = localStorage.getItem("wanime-video-subtitle-max-width") || 60;
    let skipTimesEnabled = (localStorage.getItem("wanime-video-skip-times-enabled") === "true" || 
        localStorage.getItem("wanime-video-skip-times-enabled") === null) ? true : false;

    $: selectedSubtitleLabel, localStorage.setItem("wanime-video-subtitle-label", selectedSubtitleLabel);
    $: subtitleScale, localStorage.setItem("wanime-video-subtitle-scale", subtitleScale);
    $: subtitleFontSize, localStorage.setItem("wanime-video-subtitle-font-size", subtitleFontSize);
    $: subtitleBottomOffset, localStorage.setItem("wanime-video-subtitle-bottom-offset", subtitleBottomOffset);
    $: subtitleMaxWidth, localStorage.setItem("wanime-video-subtitle-max-width", subtitleMaxWidth);
    $: skipTimesEnabled, localStorage.setItem("wanime-video-skip-times-enabled", skipTimesEnabled);

    let activeMouseTimeout;
    let activeMouse = false;

    let loading = true;

    let showSettingsPopup = false;
    let settingsPage = "";

    let videoFillScreen = (localStorage.getItem("wanime-video-fill-screen") || "false") === "true" ? true : false;

    $: videoFillScreen, localStorage.setItem("wanime-video-fill-screen", String(videoFillScreen));

    const loadSource = () => {
        if (!src) {
            hlsStream?.destroy(); hlsStream = undefined;
            videoElem?.pause();
            loading = true;
            videoBufferedTime = 0;
            return;
        }
        hlsStream?.destroy();
        selectedSubtitleFile = undefined;
        subtitleCues = [];

        hlsStream = new hlsJs();
        hlsStream.loadSource(src);
        hlsStream.attachMedia(videoElem);

        hlsStream.on(hlsJs.Events.BUFFER_APPENDED, function () {
            if (!videoElem) return;

            let i = videoElem.buffered.length - 1;
            videoBufferedTime = videoElem.buffered.end(i);
        });

        hlsStream.on(hlsJs.Events.MANIFEST_PARSED, function () {
            loading = false;
            videoElem?.play();
        });

    }

    const pointerMove = () => {
        clearTimeout(activeMouseTimeout);
        activeMouse = true;
        activeMouseTimeout = setTimeout(() => activeMouse = false, 3000);
    }

    const toggleFullscreen = () => {
        if (document.fullscreenElement || document.webkitFullscreenElement ||
        document.mozFullScreenElement) {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) { /* Safari */
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { /* IE11 */
                document.msExitFullscreen();
            }
        } else {
            if (videoWrapperElem?.requestFullscreen) {
                videoWrapperElem?.requestFullscreen();
            } else if (videoWrapperElem?.webkitRequestFullscreen) { /* Safari */
                videoWrapperElem?.webkitRequestFullscreen();
            } else if (videoWrapperElem?.msRequestFullscreen) { /* IE11 */
                videoWrapperElem?.msRequestFullscreen();
            }
        }
    }

    const togglePlayState = () => {
        if (videoElem.paused) videoElem.play();
        else videoElem.pause();
    }

    const toggleMuteState = () => {
        videoMuted = !videoMuted;
    }

    const formatTimeNumber = (num) => {
        if (num === 60) num = 0;

        return String(num).padStart(2, "0");
    }

    const videoSkip = (forward) => {
        if (forward && videoElem.currentTime + 30 > (videoElem.duration || 0)) videoElem.currentTime = (videoElem.duration || 0);
        else if (forward) videoElem.currentTime += 30;
        else if (!forward && videoElem.currentTime + 30 < 0) videoElem.currentTime = 0;
        else if (!forward) videoElem.currentTime -= 30;
    }

    const loadTrackIntoCues = async (track) => {
        if (!track) return;
        selectedSubtitleFile = track.file;
        subtitleCues = [];
        parser.parse(await (await fetch(track.file)).text());
        parser.flush();
    }

    const videoSubtitleUpdate = () => {
        subtitleTextBlocks = subtitleCues.filter(cue => cue.startTime <= videoElem.currentTime && cue.endTime >= videoElem.currentTime).map(cue => cue.text);
    }

    const onTrackArrayChange = () => {
        if (!selectedSubtitleLabel) return;
        const favTrack = tracks.find(track => track.label === selectedSubtitleLabel);
        if (favTrack) loadTrackIntoCues(favTrack);
        else loadTrackIntoCues(tracks.find(track => track.default));
    }

    const attemptPauseOnVideoClick = (e) => {
        if (!activeMouse) return;
        let elem = e.target;
        let searching = true;
        while (searching) {
            if (elem.dataset.blockPauseClick !== undefined) return;
            if (elem === videoWrapperElem) {searching = false; togglePlayState(); }
            elem = elem.parentElement;
        }
    }

    const checkForSkipTimes = () => {
        if (!skipTimesEnabled) return;
        skipTimes.forEach(skipTime => {
            if (videoCurrentTime >= skipTime.start && videoCurrentTime < skipTime.end) {
                videoCurrentTime = skipTime.end;
            }
        });
    }

</script>

<div>

    <!-- svelte-ignore a11y-click-events-have-key-events -->
    <!-- svelte-ignore a11y-no-static-element-interactions -->
    <div class="video-wrapper" class:mouse={activeMouse || showSettingsPopup} class:playing={videoPaused === false} class:muted={videoMuted} class:loading={!src} on:pointermove={pointerMove} on:click={attemptPauseOnVideoClick} bind:this={videoWrapperElem}>

        <video class:fill-screen={videoFillScreen} bind:this={videoElem} bind:paused={videoPaused} bind:muted={videoMuted} bind:currentTime={videoCurrentTime} bind:duration={videoTotalTime} on:timeupdate={() => { videoSubtitleUpdate(); checkForSkipTimes(); }}>
            <track kind="captions">
        </video>

        <div class="status-overlay">

            <div class="overlay-center overlay-hide-when-loading" class:show={videoCurrentTime >= videoBufferedTime && videoCurrentTime !== videoTotalTime}>
                <div class="spinner"></div>
                <p>Buffering</p>
            </div>

        </div>

        <div class="controls-overlay">


            <div class="bottom">

                <div class="trackbar-wrapper" data-block-pause-click>
                    <div class="trackbar" style="--width: {100 / videoTotalTime * videoCurrentTime}%;">
                        <div class="trackbar-buffer" style="--width: {100 / videoTotalTime * videoBufferedTime}%;"></div>
                        {#each skipTimes as skipTime}
                            <div class="trackbar-segment" style="--start: {100 / videoTotalTime * skipTime.start}%; --end: {100 / videoTotalTime * (skipTime.end - skipTime.start)}%;"></div>
                        {/each}
                    </div>
                </div>

                <div class="buttons">

                    <button on:click={togglePlayState} data-block-pause-click><i class="fi fi-sr-play" data-only-when-not="playing"></i><i class="fi fi-sr-pause" data-only-when="playing"></i></button>
                    <button on:click={toggleMuteState} data-block-pause-click><i class="fi fi-sr-volume-mute" data-only-when="muted"></i><i class="fi fi-sr-volume" data-only-when-not="muted"></i></button>

                    <p class="time" data-block-pause-click>
                        {#if Math.floor((videoTotalTime || 0) / 3600)}
                            <span>{ String(Math.floor((videoCurrentTime || 0) / 3600)).padStart(2, "0") }:</span>
                        {/if}
                        <span>{ formatTimeNumber( Math.floor( (videoCurrentTime || 0) / 60 ) % 60 ) }:</span>
                        <span>{ formatTimeNumber( Math.floor( videoCurrentTime || 0 ) % 60 ) }</span>
                        <span>/</span>
                        {#if Math.floor((videoTotalTime || 0) / 3600)}
                            <span>{ String(Math.floor((videoTotalTime || 0) / 3600)).padStart(2, "0") }:</span>
                        {/if}
                        <span>{ formatTimeNumber( Math.floor( (videoTotalTime || 0) / 60 ) % 60 ) }:</span>
                        <span>{ formatTimeNumber( Math.floor( videoTotalTime || 0 ) % 60 ) }</span>
                    </p>

                    <div class="right" data-block-pause-click>

                        <button on:click={() => videoSkip(false)}><i class="fi fi-sr-angle-double-small-left"></i></button>
                        <button on:click={() => videoSkip(true)}><i class="fi fi-sr-angle-double-small-right"></i></button>
                        <button on:click={() => setTimeout(() => showSettingsPopup = !showSettingsPopup, 20)}><i class="fi fi-sr-settings"></i></button>
                        <button on:click={toggleFullscreen}><i class="fi fi-sr-expand" data-only-when-not="fullscreen"></i><i class="fi fi-sr-compress" data-only-when="fullscreen"></i></button>

                    </div>


                </div>

            </div>

        </div>

        <div class="subtitles-overlay" style="--scale: {Number(subtitleScale) / 100}; --fontsize: {subtitleFontSize}px; --bottom-offset: {subtitleBottomOffset}px; --btn-visible-bottom-offset: {subtitleBottomOffset > 56 ? `${subtitleBottomOffset}px` : "3.5rem"}; --max-width: {subtitleMaxWidth}%;" data-block-pause-click>
            {#each subtitleTextBlocks as block}
                <p>{@html block}</p>
            {/each}
        </div>

        <div class="settings-overlay" class:show={showSettingsPopup} use:clickOutside on:click_outside={() => {if (showSettingsPopup) setTimeout(() => showSettingsPopup = false, 40)}} data-block-pause-click>

            <div class="page" class:show={!settingsPage} id="home">

                <button class="item" on:click={() => settingsPage = "subtitles"}><p>Subtitles</p><i class="fi fi-sr-angle-small-right"></i></button>
                <button class="item" on:click={() => settingsPage = "miscellaneous"}><p>Miscellaneous</p><i class="fi fi-sr-angle-small-right"></i></button>

            </div>

            <div class="page" class:show={settingsPage === "subtitles"} id="subtitles">

                <button class="back-btn" on:click={() => settingsPage = ""}><i class="fi fi-sr-arrow-small-left"></i><p>Back</p></button>

                <div class="section" id="tracks">
                    <p class="label">Subtitles</p>
                    <button class="item" on:click={() => {selectedSubtitleFile = undefined; selectedSubtitleLabel = ""; subtitleCues = [];}}><i class="fi fi-sr-check-circle" class:show={!selectedSubtitleFile}></i><p>Disabled</p></button>
                    {#each tracks as track}
                        <button class="item" on:click={() => { selectedSubtitleLabel = track.label; loadTrackIntoCues(track); }}><i class="fi fi-sr-check-circle" class:show={selectedSubtitleFile === track.file}></i><p>{track.label}</p></button>
                    {/each}
                </div>

                <div class="section" id="more">
                    <p class="label">More</p>
                    <div class="item"><p>Scale</p><div class="right"><input type="text" bind:value={subtitleScale}><p>%</p></div></div>
                    <div class="item"><p>Font Size</p><div class="right"><input type="text" bind:value={subtitleFontSize}><p>px</p></div></div>
                    <div class="item"><p>Bottom Offset</p><div class="right"><input type="text" bind:value={subtitleBottomOffset}><p>px</p></div></div>
                    <div class="item"><p>Max Width</p><div class="right"><input type="text" bind:value={subtitleMaxWidth}><p>%</p></div></div>
                </div>

            </div>

            <div class="page" class:show={settingsPage === "miscellaneous"} id="miscellaneous">

                <button class="back-btn" on:click={() => settingsPage = ""}><i class="fi fi-sr-arrow-small-left"></i><p>Back</p></button>

                <button on:click={() => videoFillScreen = !videoFillScreen} class="item"><p>Fill Screen</p><p>{videoFillScreen ? "On" : "Off"}</p></button>
                <button on:click={() => skipTimesEnabled = !skipTimesEnabled} class="item"><p>Enable SkipTimes</p><p>{skipTimesEnabled ? "On" : "Off"}</p></button>

            </div>

        </div>

    </div>


</div>

<style>

    .video-wrapper {
        border-radius: .5rem;
        overflow: hidden;

        position: relative;
        isolation: isolate;
    }
    .video-wrapper:not(.mouse) { cursor: none; }
    .video-wrapper:fullscreen { border-radius: 0; }

    video {
        display: block;

        width: 100%;

        aspect-ratio: 16/9;
        background-color: #000;
    }
    .video-wrapper:fullscreen video {
        aspect-ratio: unset;
        height: 100%;
    }
    .video-wrapper:fullscreen video.fill-screen {
        object-fit: cover;
    }

    .video-wrapper .status-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;

        pointer-events: none;

        transition: background-color 500ms;
    }
    .video-wrapper .status-overlay:has(.show) {background-color: #00000057;}

    .video-wrapper .status-overlay > * {opacity: 0;}
    .video-wrapper .status-overlay > *.show {opacity: 1;}
    .video-wrapper.loading .status-overlay > .overlay-hide-when-loading {opacity: 0;}

    .video-wrapper .status-overlay .overlay-center {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);

        display: flex; gap: .5rem;
        flex-direction: column;
        align-items: center;
    }

    .video-wrapper .controls-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;

        transition: background-color 250ms;
    }

    .video-wrapper .controls-overlay .bottom {
        display: flex;
        flex-direction: column;
        justify-content: end;

        position: absolute;
        bottom: 0; left: 0;
        width: 100%; height: 10rem;

        background: rgb(0,0,0);
        background: linear-gradient(0deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.6) 38%, rgba(0,0,0,0) 100%); 

        opacity: 0;
        transition: opacity 200ms;
    }

    .video-wrapper.mouse .controls-overlay .bottom, .video-wrapper:not(.playing) .controls-overlay .bottom { opacity: 1; }

    .video-wrapper .controls-overlay .bottom .buttons {
        display: flex;
        align-items: center;

        padding: .5rem;
    }

    .video-wrapper .controls-overlay .bottom .buttons button {
        display: block;

        padding: .5rem;

        background-color: transparent;
        border: none;
        border-radius: 0;

        color: #ffffffb4;

        cursor: pointer;
    }
    .video-wrapper .controls-overlay .bottom .buttons button:hover {color: #fff;}

    .video-wrapper:fullscreen .controls-overlay .bottom .buttons button i[data-only-when-not="fullscreen"] {display: none;}
    .video-wrapper:not(:fullscreen) .controls-overlay .bottom .buttons button i[data-only-when="fullscreen"] {display: none;}

    .video-wrapper.playing .controls-overlay .bottom .buttons button i[data-only-when-not="playing"] {display: none;}
    .video-wrapper:not(.playing) .controls-overlay .bottom .buttons button i[data-only-when="playing"] {display: none;}

    .video-wrapper.muted .controls-overlay .bottom .buttons button i[data-only-when-not="muted"] {display: none;}
    .video-wrapper:not(.muted) .controls-overlay .bottom .buttons button i[data-only-when="muted"] {display: none;}

    .video-wrapper .controls-overlay .bottom .buttons .right {
        display: flex;
        align-items: center;

        margin-left: auto;
    }

    .video-wrapper .controls-overlay .bottom .buttons p.time {
        display: flex;

        margin-bottom: -.1rem;
        margin-left: .25rem;
    }

    .video-wrapper .controls-overlay .bottom .trackbar-wrapper {
        padding: 0 .75rem;
    }

    .video-wrapper .controls-overlay .bottom .trackbar-wrapper .trackbar {
        position: relative;

        width: 100%;
        height: 3px;
        background-color: #575757;

        cursor: pointer;
        overflow: hidden;
        isolation: isolate;
    }

    .video-wrapper .controls-overlay .bottom .trackbar-wrapper .trackbar::after {
        content: "";

        position: absolute;
        top: 0; left: 0;
        
        width: var(--width, 0%);
        height: 100%;

        background-color: #fff;
    }

    .video-wrapper.loading .controls-overlay .bottom .trackbar-wrapper .trackbar::after {
        animation: widthAni 4s infinite linear;
    }
    @keyframes widthAni {
        0% {width: 30%; left: -30%;}
        100% {width: 30%; left: 120%;}
    }

    .video-wrapper .controls-overlay .bottom .trackbar-wrapper .trackbar .trackbar-buffer {
        position: absolute;
        top: 0; left: 0;
        
        width: var(--width, 0%);
        height: 100%;

        background-color: #888888;
    }
    .video-wrapper.loading .controls-overlay .bottom .trackbar-wrapper .trackbar .trackbar-buffer {opacity: 0;}

    .video-wrapper .controls-overlay .bottom .trackbar-wrapper .trackbar .trackbar-segment {
        position: absolute;
        top: 0; left: var(--start, 0%);
        z-index: 3;
        
        width: var(--end, 0%);
        height: 100%;

        background-color: #c4da00;
    }
    .video-wrapper.loading .controls-overlay .bottom .trackbar-wrapper .trackbar .trackbar-segment {opacity: 0;}


    .video-wrapper .subtitles-overlay {
        display: flex; gap: .25rem;
        flex-direction: column;
        justify-content: end;
        align-items: center;

        position: absolute;
        bottom: var(--bottom-offset, 1rem); left: 0;
        width: 100%; height: 100%;

        pointer-events: none;

        transition: bottom 500ms;
    }
    .video-wrapper.mouse .subtitles-overlay,
    .video-wrapper.loading .subtitles-overlay,
    .video-wrapper:not(.playing) .subtitles-overlay {
        bottom: var(--btn-visible-bottom-offset, 3.5rem);
    }

    .video-wrapper .subtitles-overlay p {
        display: block;

        max-width: var(--max-width, 60%);
        padding: .25rem .5rem;
        transform: scale(var(--scale, 1));

        background-color: #0000009f;
        border-radius: .5rem;

        color: #fff;
        font-size: var(--fontsize, 16px);

        pointer-events: all;
    }


    .video-wrapper .settings-overlay {
        position: absolute;
        bottom: 4rem; right: 1rem;
        width: min(16rem, calc(100% - 2rem)); height: min(17rem, calc(100% - 5rem));

        background-color: var(--body-secondary-bg);
        border-radius: .5rem;
        border: 2px solid var(--body-tertiary-bg);

        opacity: 0;
        transition: opacity 250ms;
        overflow: auto;
    }
    .video-wrapper .settings-overlay.show {opacity: 1;}

    .video-wrapper .settings-overlay .page {display: none;}
    .video-wrapper .settings-overlay .page.show {
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }

    .video-wrapper .settings-overlay .page button.back-btn {
        display: flex; gap: .5rem;
        align-items: center;

        padding: .5rem;

        background-color: transparent;
        border: none;
        border-radius: 0;
        border-bottom: 1px solid var(--body-tertiary-bg);

        color: var(--body-color);

        cursor: pointer;
    }
    .video-wrapper .settings-overlay .page button.back-btn:hover {
        background-color: rgba(var(--body-tertiary-bg-rgb), .3);
    }

    .video-wrapper .settings-overlay .page .section {
        padding: .5rem 0;
        border-bottom: 1px solid var(--body-tertiary-bg);
    }
    .video-wrapper .settings-overlay .page .section p.label {
        margin: 0 0 0 .5rem;
        color: var(--body-tertiary-color);
    }

    .video-wrapper .settings-overlay .page#home button {
        display: flex;
        justify-content: space-between;
        align-items: center;

        background-color: transparent;
        border: none;

        padding: .5rem 1rem;

        color: var(--body-color);

        cursor: pointer;
    }
    .video-wrapper .settings-overlay .page#home button:not(:last-of-type) {
        border-bottom: 1px solid var(--body-tertiary-bg);
    }

    .video-wrapper .settings-overlay .page#subtitles #tracks button {
        display: flex; gap: .5rem;
        align-items: center;

        background-color: transparent;
        border: none;

        padding: .25rem .5rem;
        width: 100%;
        box-sizing: border-box;

        color: var(--body-color);
        font-size: unset;
        text-align: left;

        cursor: pointer;
    }
    .video-wrapper .settings-overlay .page#subtitles #tracks button i {opacity: 0;}
    .video-wrapper .settings-overlay .page#subtitles #tracks button i.show {opacity: 1;}

    .video-wrapper .settings-overlay .page#subtitles #more .item {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: .25rem .5rem;
    }
    .video-wrapper .settings-overlay .page#subtitles #more .item input {
        padding: .25rem .5rem;
        width: 3rem;

        background-color: transparent;
        border: 1px solid var(--body-tertiary-bg);
        border-radius: .5rem;

        color: var(--body-color);
        outline: 0px solid var(--body-tertiary-bg);

        transition: outline 200ms;
    }
    .video-wrapper .settings-overlay .page#subtitles #more .item input:focus {
        outline: 3px solid var(--body-tertiary-bg);
    }

    .video-wrapper .settings-overlay .page#subtitles #more .item .right {
        display: flex; gap: .25rem;
        align-items: center;
    }


    .video-wrapper .settings-overlay .page#miscellaneous button.item {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: .5rem;

        border: none;
        border-radius: 0;
        background-color: transparent;

        color: var(--body-color);

        cursor: pointer;
    }



    .spinner {
        border: 2px solid #fff;
        border-bottom: 2px solid transparent;
        border-right: 2px solid transparent;
        border-radius: 50%;
        padding: .75rem;

        animation: spinnerVideo 1s infinite linear;
    }

    @keyframes spinnerVideo {
        0% {transform: rotateZ(0deg);}
        100% {transform: rotateZ(360deg);}
    }

</style>