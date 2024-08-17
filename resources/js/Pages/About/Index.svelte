<script>

    import Layout from "../../Layout/Main/Index.svelte";
    import AnimeInfoTabs from "../../Modules/AnimeInfoTabs.svelte";
    import Button from "../../Modules/Button.svelte";
    import WatchlistButton from "../../Modules/WatchlistButton.svelte";

    import { page } from '@inertiajs/svelte'

    export let anime = {};
    export let watchlistStatus;
    export let seasons = [];
    export let relatedAnime = [];
    export let recommendAnime = [];

</script>

<Layout><main>

    <div class="center">

        <img class="poster" src="{ anime.info.poster }" alt="">
        <div class="center" style="gap: .25rem;">
            <AnimeInfoTabs tabs={Object.values(anime.info.stats).map(obj => { return {val: obj}; })} />
            <AnimeInfoTabs tabs={[{icon: "sr-subtitles", val: anime.info.stats.episodes.sub || 0}, {icon: "sr-microphone", val: anime.info.stats.episodes.dub || 0}]} />
        </div>

        <h3 class="center" style="margin: .5rem 0;">{anime.info.name}</h3>

        <div class="center" style="flex-direction: row;">
            <Button href={`/watch?id=${anime.info.id}`} title={"Watch"} icon={"sr-play-circle"} style={"rounded"} />

            {#if $page?.props?.auth?.user}
                <WatchlistButton anime={{id: anime.info.id, poster: anime.info.poster, title: anime.info.name}} theme={"secondary"} initialStatus={watchlistStatus} />
            {/if}
        </div>

    </div>

</main></Layout>

<style>

    div.center {
        display: flex; gap: .5rem;
        flex-direction: column;
        align-items: center;
    }

    h3.center {
        text-align: center;
    }

    .poster {
        width: 14rem;
        border-radius: .25rem;
    }

</style>