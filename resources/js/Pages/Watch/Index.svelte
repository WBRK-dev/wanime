<script>
    import { onMount } from "svelte";
    import { page } from "@inertiajs/svelte";

    import Layout from "../../Layout/Main/Index.svelte";
    import Episodes from "./Episodes.svelte";
    import Servers from "./Servers.svelte";
    import Video from "./Video.svelte";

    export let anime = {};
    export let episodes = [];
    export let watchlistStatus;
    export let seasons = [];
    export let relatedAnime = [];
    export let recommendAnime = [];
    export let apiUrl = "";
    export let selectedEpisodeIndex = 0;
    export let routes = {};

    let currentEpisode = 0;
    let episodeServers = {sub: [], dub: [], raw: []};
    let currentEpisodeVideoSource;
    let currentEpisodeSubtitles = [];
    let currentEpisodeSkipTimes = [];

    let selectedCategory;
    let selectedServer;

    onMount(() => {

        selectedCategory = localStorage.getItem("wanime-video-category") || "sub";
        selectedServer = localStorage.getItem("wanime-video-server");

        loadEpisode(selectedEpisodeIndex);

    });

    const loadEpisode = async e => {

        currentEpisode = e;
        currentEpisodeVideoSource = undefined;
        episodeServers.sub = []; episodeServers.dub = [];
        currentEpisodeSubtitles = [];
        currentEpisodeSkipTimes = [];

        const response = await fetch(`${apiUrl}/anime/servers?episodeId=${episodes[currentEpisode].episodeId}`);
        const json = await response.json();
        if (json.error) throw new Error("Loading episode failed");

        episodeServers.sub = json.sub.filter(obj => obj.serverId === 4 || obj.serverId === 1);
        episodeServers.dub = json.dub.filter(obj => obj.serverId === 4 || obj.serverId === 1);
        episodeServers.raw = json.raw.filter(obj => obj.serverId === 4 || obj.serverId === 1);

        if (episodeServers[selectedCategory]?.filter(obj => obj.serverName === selectedServer).length > 0) loadServer(selectedServer, selectedCategory);
        else if (episodeServers[selectedCategory].length > 0) loadServer(episodeServers[selectedCategory][0].serverName, selectedCategory);
        else if (episodeServers["sub"].length > 0) loadServer(episodeServers["sub"][0].serverName, "sub");

        fetch(routes["anime-update-episode"], {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                _method: "PUT",
                _token: $page.props.csrf_token,
                episode: e
            }),
        });

    }

    const loadServer = async (server, category) => {

        selectedCategory = category;
        selectedServer = server;
        localStorage.setItem("wanime-video-category", selectedCategory);
        localStorage.setItem("wanime-video-server", selectedServer);

        const response = await fetch(`${apiUrl}/anime/episode-srcs?id=${episodes[currentEpisode].episodeId}&server=${server}&category=${category}`);
        const json = await response.json();
        if (json.error) throw new Error("Loading episode failed");

        currentEpisodeVideoSource = json.sources.find(obj => obj.type === "hls")?.url;
        currentEpisodeSubtitles = json.tracks.filter(obj => obj.kind === "captions");

        if (json.intro) {
            currentEpisodeSkipTimes.push({
                start: json.intro.start,
                end: json.intro.end,
                type: "intro"
            });
        }
        if (json.outro) {
            currentEpisodeSkipTimes.push({
                start: json.outro.start,
                end: json.outro.end,
                type: "outro"
            });
        }

    }

    const attemptNextEp = () => {
        if (currentEpisode + 1 < episodes.length - 1) loadEpisode(currentEpisode + 1);
    }

</script>

<Layout paddingSize={"1rem"} padding={false}>

    <div class="columns">

        <div id="episodes"><Episodes episodes={episodes} current={currentEpisode} on:click={(e) => loadEpisode(e.detail)} /></div>

        <div id="video">
            <Video src={currentEpisodeVideoSource} tracks={currentEpisodeSubtitles} skipTimes={currentEpisodeSkipTimes} on:nextEp={attemptNextEp}/>
            <Servers on:click={(e) => loadServer(e.detail.server, e.detail.category)} sub={episodeServers.sub} dub={episodeServers.dub} raw={episodeServers.raw} selectedCategory={selectedCategory} selectedServer={selectedServer} />
        </div>

        <div id="info" class="wip-bg" style="border-radius: .5rem;"><div class="test"></div></div>

    </div>

</Layout>

<style>

    .test {padding: 5rem; box-sizing: border-box;}

    .columns {
        display: grid;
        grid-template-columns: 20rem 1fr 20rem;
        gap: var(--layout-padding);
    }

    .columns #video {
        display: flex; gap: var(--layout-padding);
        flex-direction: column;
    }

    @media only screen and (max-width: 80rem) {
        .columns {
            grid-template-columns: 20rem 1fr;
        }

        #info {
            grid-column: 1/3;
        }
    }

    @media only screen and (max-width: 62.5rem) {
        .columns {
            grid-template-columns: 1fr;
        }

        #video {
            order: -1;
        }

        #info {
            grid-column: unset;
        }
    }


</style>
