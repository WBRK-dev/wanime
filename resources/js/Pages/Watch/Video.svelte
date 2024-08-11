<script>

    import hlsJs from "https://cdn.jsdelivr.net/npm/hls.js@1.5.13/+esm";

    export let src;

    $: src, loadSource();

    let hlsStream;
    let videoWrapperElem;
    let videoElem;
    let videoPaused;
    let videoMuted = true;
    let videoCurrentTime;
    let videoTotalTime;
    let videoBufferedTime = 0;

    let activeMouseTimeout;
    let activeMouse = false;

    let loading = true;

    const loadSource = () => {
        if (!src) {
            hlsStream?.destroy(); hlsStream = undefined;
            videoElem?.pause();
            loading = true;
            videoBufferedTime = 0;
            return;
        }
        hlsStream?.destroy();

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

</script>

<div>

    <div class="video-wrapper" class:mouse={activeMouse} class:playing={videoPaused === false} class:muted={videoMuted} class:loading={!src} on:pointermove={pointerMove} bind:this={videoWrapperElem}>

        <video bind:this={videoElem} bind:paused={videoPaused} bind:muted={videoMuted} bind:currentTime={videoCurrentTime} bind:duration={videoTotalTime}>
            <track kind="captions">
        </video>

        <div class="status-overlay">

            <div class="overlay-center overlay-hide-when-loading" class:show={videoCurrentTime >= videoBufferedTime}>
                <div class="spinner"></div>
                <p>Buffering</p>
            </div>

        </div>

        <div class="controls-overlay">


            <div class="bottom">

                <div class="trackbar-wrapper"><div class="trackbar" style="--width: {Math.round( 100 / videoTotalTime * videoCurrentTime )}%;"><div class="trackbar-buffer" style="--width: {Math.round( 100 / videoTotalTime * videoBufferedTime )}%;"></div></div></div>

                <div class="buttons">

                    <button on:click={togglePlayState}><i class="fi fi-sr-play" data-only-when-not="playing"></i><i class="fi fi-sr-pause" data-only-when="playing"></i></button>
                    <button on:click={toggleMuteState}><i class="fi fi-sr-volume-mute" data-only-when="muted"></i><i class="fi fi-sr-volume" data-only-when-not="muted"></i></button>

                    <p class="time">
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

                    <div class="right">

                        <button on:click={() => videoSkip(false)}><i class="fi fi-sr-angle-double-small-left"></i></button>
                        <button on:click={() => videoSkip(true)}><i class="fi fi-sr-angle-double-small-right"></i></button>
                        <button on:click={toggleFullscreen}><i class="fi fi-sr-expand" data-only-when-not="fullscreen"></i><i class="fi fi-sr-compress" data-only-when="fullscreen"></i></button>


                    </div>


                </div>

            </div>

        </div>

    </div>


</div>

<style>

    .video-wrapper {
        border-radius: .5rem;
        overflow: hidden;

        position: relative;
    }
    .video-wrapper:not(.mouse) { cursor: none; }
    .video-wrapper:fullscreen { border-radius: 0; }

    video {
        display: block;

        width: 100%;

        aspect-ratio: 16/9;
        background-color: #000;
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