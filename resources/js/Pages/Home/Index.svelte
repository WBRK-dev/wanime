<script>
    import { inertia } from '@inertiajs/svelte';


    import Layout from '../../Layout/Main/Index.svelte';
    import AnimeGrid from '../../Modules/AnimeGrid.svelte';
    import EstimatedEpisodes from './EstimatedEpisodes.svelte';
    import Spotlight from './Spotlight.svelte';

    export let watchlist;
    export let reviews = [];
    export let estimatedEpisodes = [];
    export let spotlight = [];
    export let trending = [];
    export let latest = [];
    export let topUpcoming = [];
    export let top10 = [];
    export let topAiring = [];
    export let genres = [];
    export let routes = {};

</script>

<Layout padding={false}>

    <Spotlight animes={spotlight} routes={routes} />
    
    <div class="wrapper">

        {#if watchlist && watchlist.length}
            <AnimeGrid title={"Watching"} animes={watchlist.map(anime => { return {id: anime.animeId, anime: anime.anime, currentEpisode: anime.episode + 1}; })} url={routes["anime-watch"]} />
        {/if}

        <AnimeGrid title={"New Episodes"} animes={latest} url={routes["anime-show"]} />

        <div id="reviews">
            <h3>Reviews</h3>
            {#if reviews.length}
                <div class="bak">
                    {#each reviews as review}
                        <div class="review-wrapper">
                            <div class="author">
                                <i class="fi fi-sr-user"></i>
                                <p>{review.user.name}</p>
                            </div>
                            <a href="/anime?id={review.anime.id}" class="anime" use:inertia><p>{review.anime.title}</p></a>
                            <div class="stars">
                                <i class="fi fi-sr-star"></i>
                                <i class="fi fi-sr-star"></i>
                                <i class="fi fi-sr-star"></i>
                                <i class="fi fi-sr-star"></i>
                                <i class="fi fi-sr-star"></i>
                            </div>
                        </div>
                    {/each}
                </div>
            {:else}
                <p style="color: var(--body-secondary-color);">No reviews available!</p>
            {/if}
        </div>

        <AnimeGrid title={"Popular"} animes={topAiring} url={routes["anime-show"]} />
        <AnimeGrid title={"Trending"} animes={trending} url={routes["anime-show"]} />

        <EstimatedEpisodes episodes={estimatedEpisodes} url={routes["anime-show"]} />

        <AnimeGrid title={"Top Upcoming"} animes={topUpcoming} url={routes["anime-show"]} />

    </div>
</Layout>

<style>

    .wrapper {
        display: flex; gap: .5rem;
        flex-direction: column;
        padding: .5rem;
    }

    #reviews {
        margin-left: -.5rem;
        width: 100%;
        padding: .5rem;

        background-color: var(--body-secondary-bg);
    }

    #reviews .bak {
        display: flex;
        gap: .5rem;

        margin-top: .5rem;

        overflow: auto;
    }

    #reviews .review-wrapper {
        display: flex;
        flex-direction: column;

        padding: .5rem;
        width: 300px;
        flex-shrink: 0;

        border-radius: .5rem;
        background-color: var(--body-tertiary-bg);
    }

    #reviews .review-wrapper .author {
        display: flex; gap: .25rem;
        align-items: center;

        color: var(--body-tertiary-color);
    }

    #reviews .review-wrapper .anime {
        text-decoration: none;
        color: var(--body-color);
        margin-bottom: .5rem;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    #reviews .review-wrapper .stars {
        display: flex; gap: .5rem;
        justify-content: center;

        margin-top: auto;
    }

    #reviews .review-wrapper .stars i {
        font-size: 1.5rem;
    }

</style>