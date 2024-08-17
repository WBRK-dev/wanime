<script>

    import { inertia } from "@inertiajs/svelte";

    export let anime = {};
    export let isWatchCard = false;

</script>

<a use:inertia href="/{(isWatchCard ? "watch" : "anime")}?id={anime.animeId || anime.id}" class="wrapper">

    <div class="img-wrapper">

        <img src="{anime?.poster || anime?.image || anime?.anime?.image}" alt="">

        {#if anime.episodes || anime.currentEpisode}
            <div class="episodes">

                {#if anime.episodes}
                    <div class="episode">
                        <i class="fi fi-sr-subtitles"></i>
                        <p>{anime.episodes.sub || 0}</p>
                    </div>
                    <div class="episode">
                        <i class="fi fi-sr-microphone"></i>
                        <p>{anime.episodes.dub || 0}</p>
                    </div>
                {/if}

                {#if anime.currentEpisode}
                    <div class="episode">
                        <i class="fi fi-sr-play-circle"></i>
                        <p>{anime.currentEpisode}</p>
                    </div>
                {/if}

            </div>
        {/if}

    </div>

    <div class="info-wrapper">

        <p>{anime?.name || anime?.anime?.title || anime?.title}</p>

    </div>

</a>

<style>

    .wrapper {
        text-decoration: none;
        color: var(--body-color);
    }

    .img-wrapper {
        position: relative;
    }

    .img-wrapper img {
        width: 100%;
        aspect-ratio: 1/1.40;
        object-fit: cover;
        border-radius: .5rem;
    }

    .info-wrapper {
        padding: .5rem 0;
    }

    .info-wrapper p {
        font-weight: 700;

        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .episodes {
        position: absolute;
        bottom: .5rem; left: .35rem;

        display: flex; gap: .125rem;

        border-radius: .25rem;

        overflow: hidden;
    }

    .episodes .episode {
        display: flex; gap: .4rem;
        align-items: center;

        padding: .125rem .4rem;

        background-color: rgba(0, 0, 0, 0.651);
    }

    .episodes .episode i {
        font-size: .75rem;
    }

    .episodes .episode p {
        font-size: .85rem;
        margin-bottom: -.05rem;
    }

</style>