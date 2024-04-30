<script>

    const ffmpeg = new FFmpegWASM.FFmpeg;
    const M3u8Parser = m3u8Parser.Parser;
    let loadedFfmpegCore = false;
    let downloadDialogProgressBar;
    let downloadDialogProgressBarDataLeft;
    let downloadDialogProgressBarDataRight;
    
    const PLAYLIST = "PLAYLIST";
    const SEGMENT = "SEGMENT";
    const ERROR = "ERROR";
    const TS_MIMETYPE = "video/mp2t";
    const START_DOWNLOAD = "Download";
    const DOWNLOAD_ERROR = "Download Error";
    const STARTING_DOWNLOAD = "Download starting";
    const SEGMENT_STARTING_DOWNLOAD = "Segments downloading";
    const SEGMENT_STICHING = "Stiching segments";
    const JOB_FINISHED = "Ready for download";
    const SEGMENT_CHUNK_SIZE = 10;
    const SEGMENTS_DIR = "/home/web_user/segments";

    async function downloadHandler() {
        if (!loadedUrl) return;
        console.log("Loading: " + loadedUrl);
        
        const popup = wpopups.get("download");
        $(popup).find("#spinner").removeClass('d-none');
        $(popup).find("#resolutions").addClass('d-none');
        $(popup).find("#progressbar").addClass('d-none');
        $(popup).find(".w-popup-buttonbox").removeClass('d-none');
        wpopups.show("download");

        video.pause();
        downloadDialogProgressBar = $(popup).find("#progressbar .w-progressbar");
        downloadDialogProgressBarDataLeft = $(popup).find("#progressbar #data #left");
        downloadDialogProgressBarDataRight = $(popup).find("#progressbar #data #right");

        const mainManifest = await parseHls({ hlsUrl: loadedUrl });
        if (mainManifest.type === PLAYLIST) {
            $(popup).find("#spinner").addClass('d-none');
            $(popup).find("#resolutions").html("");
            $(popup).find("#resolutions").removeClass('d-none');
            mainManifest.data.forEach(data => $(popup).find("#resolutions").append(`<button class="btn btn-secondary" onclick="transformM3u8File('${data.uri}')">${ data.name.split("x")[1] }p</button>`));
        } else if (mainManifest.type === SEGMENT) {

        } else {

        }
    }

    async function loadFfmpegCore() {
        if (loadedFfmpegCore) return;
        const baseURL = './c/ffmpeg-core'

        ffmpeg.on('log', ({ message }) => {
            console.log(message);
        });

        ffmpeg.on('progress', ({ progress, time }) => {
            downloadDialogProgressBar.css("--width", `${Math.round(progress * 100)}%`);
            downloadDialogProgressBarDataLeft.text(`${ Math.round(progress * 100) }%`);
            downloadDialogProgressBarDataRight.text(formatTimeFromFfmpeg(time));
            console.log(time);
        });

        await ffmpeg.load({
            coreURL: await FFmpegUtil.toBlobURL(`${baseURL}/ffmpeg-core.js`, 'text/javascript'),
            wasmURL: await FFmpegUtil.toBlobURL(`${baseURL}/ffmpeg-core.wasm`, 'application/wasm'),
        });

        ffmpeg.createDir(SEGMENTS_DIR);

        loadedFfmpegCore = true;
        console.log("FFMPEG CORE LOADED");
    }

    async function transformM3u8File(m3u8File) {
        const popup = wpopups.get("download");
        $(popup).find("#spinner").removeClass('d-none');
        $(popup).find("#resolutions").addClass('d-none');
        $(popup).find("#progressbar").addClass('d-none');
        $(popup).find(".w-popup-buttonbox").addClass('d-none');
        wpopups.show("download");

        await loadFfmpegCore();

        let totalSegments = 0;
        let fetchedSegments = 0;

        try {

            let getSegments = await parseHls({ hlsUrl: m3u8File, headers: {} });
            if (getSegments.type !== SEGMENT)
                throw new Error(`Invalid segment url, Please refresh the page`);

            let segments = getSegments.data.map((s, i) => ({ ...s, index: i }));

            totalSegments = segments.length;

            let segmentChunks = [];
            for (let i = 0; i < segments.length; i += SEGMENT_CHUNK_SIZE) {
                segmentChunks.push(segments.slice(i, i + SEGMENT_CHUNK_SIZE));
            }

            let successSegments = [];

            $(popup).find("#spinner").addClass('d-none');
            $(popup).find("#resolutions").addClass('d-none');
            $(popup).find("#progressbar").removeClass('d-none');

            for (let i = 0; i < segmentChunks.length; i++) {

                let segmentChunk = segmentChunks[i];

                await Promise.all(
                    segmentChunk.map(async (segment) => {
                        try {
                            let fileId = `${segment.index}.ts`;
                            console.log(`Fetching ${fileId}`);
                            let getFile = await fetch(segment.uri);

                            if (!getFile.ok) throw new Error("File failed to fetch");

                            fetchedSegments++;
                            downloadDialogProgressBar.css("--width", `${Math.round( 100 / totalSegments * fetchedSegments )}%`);
                            downloadDialogProgressBarDataLeft.text(`${ Math.round( 100 / totalSegments * fetchedSegments ) }%`);
                            downloadDialogProgressBarDataRight.text(`${fetchedSegments}/${totalSegments}`);

                            ffmpeg.writeFile(
                                `${SEGMENTS_DIR}/${fileId}`,
                                new Uint8Array(await getFile.arrayBuffer())
                            );
                            successSegments.push(fileId);
                            console.log(`[SUCCESS] Segment downloaded ${segment.index}`);
                        } catch (error) {
                            console.log(`[ERROR] Segment download error ${segment.index}`);
                        }
                    })
                );
            }

            successSegments = successSegments.sort((a, b) => {
                let aIndex = parseInt(a.split(".")[0]);
                let bIndex = parseInt(b.split(".")[0]);
                return aIndex - bIndex;
            });

            await ffmpeg.exec(
                [
                    "-i",
                    `concat:${successSegments.map(segm => segm = `${SEGMENTS_DIR}/${segm}`).join("|")}`,
                    "-c:v",
                    "copy",
                    `${SEGMENTS_DIR}/output.mp4`
                ]
            );

            for (const segment of successSegments.map(segm => segm = `${SEGMENTS_DIR}/${segm}`)) {
                try {
                    ffmpeg.deleteFile(segment);
                } catch (_) { }
            }

            let blobUrl;

            try {
                const data = await ffmpeg.readFile(`${SEGMENTS_DIR}/output.mp4`);
                blobUrl = URL.createObjectURL( new Blob([data.buffer], { type: "video/mp4" }) );
                ffmpeg.deleteFile(`${SEGMENTS_DIR}/output.mp4`);
            } catch (_) {
                console.log("Error while creating blob url", _);
                throw new Error(`Something went wrong while stiching!`);
            }

            wpopups.hide();
            downloadFile(blobUrl);
        } catch (_) { }
    }

    function downloadFile(url) {
        const a = document.createElement("a");
        a.setAttribute("download", getEpisodeString());
        a.href = url;
        a.click();
        console.log(a);
    }

    function formatTimeFromFfmpeg(time) {
        let totalSeconds = time / 1000000;

        let seconds = Math.round(totalSeconds % 60);
        let minutes = Math.round(Math.floor(totalSeconds / 60) % 60);
        let hours = Math.floor(totalSeconds / 3600);

        if (seconds === 60) {seconds = 0; minutes++;}
        if (minutes === 60) {minutes = 0; hours++;}

        return `${ hours >= 1 ? `${formatTimeToTwoCharacters(hours)}:` : ""}${formatTimeToTwoCharacters(minutes)}:${formatTimeToTwoCharacters(seconds)}`;
    }

    function formatTimeToTwoCharacters(time) {
        return (String(time)).length === 1 ? `0${time}` : time;
    }

    function getEpisodeString() {
        if (!episodeId) `{{ $anime["anime"]["info"]["name"] }}`;
        return `{{ $anime["anime"]["info"]["name"] }} - Episode ${ anime.episodes.episodes.find(ep => ep.episodeId === episodeId).number || 0 }`;
    }

    // M3U8 Parser
    async function parseHls({ hlsUrl, headers = {} }) {
        try {
            let url = new URL(hlsUrl);

            let response = await fetch(url.href, {
            headers: {
                ...headers,
            },
            });
            if (!response.ok) throw new Error(response.text());
            let manifest = await response.text();

            var parser = new M3u8Parser();
            parser.push(manifest);
            parser.end();

            let path = hlsUrl;

            try {
                let pathBase = url.pathname.split("/");
                pathBase.pop();
                pathBase.push("{!! "{{URL}}" !!}");
                path = pathBase.join("/");
            } catch (perror) {
                console.info(`[Info] Path parse error`, perror);
            }

            let base = url.origin + path;

            if (parser.manifest.playlists?.length) {
            let groups = parser.manifest.playlists;

            groups = groups
                .map((g) => {
                return {
                    name: g.attributes.NAME
                    ? g.attributes.NAME
                    : g.attributes.RESOLUTION
                    ? `${g.attributes.RESOLUTION.width}x${g.attributes.RESOLUTION.height}`
                    : `MAYBE_AUDIO:${g.attributes.BANDWIDTH}`,
                    bandwidth: g.attributes.BANDWIDTH,
                    uri: g.uri.startsWith("http")
                    ? g.uri
                    : base.replace("{!! "{{URL}}" !!}", g.uri),
                };
                })
                .filter((g) => g);

            return {
                type: PLAYLIST,
                data: groups,
            };
            } else if (parser.manifest.segments?.length) {
            let segments = parser.manifest.segments;
            segments = segments.map((s) => ({
                ...s,
                uri: s.uri.startsWith("http") ? s.uri : base.replace("{!! "{{URL}}" !!}", s.uri),
            }));

            return {
                type: SEGMENT,
                data: segments,
            };
            }
        } catch (error) {
            return {
                type: ERROR,
                data: error.message,
            };
        }
    }

</script>