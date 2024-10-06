<script>
    import Layout from "../../../Layout/Main/Index.svelte";
    import AnimeGrid from "../../../Modules/AnimeGrid.svelte";

    import { inertia } from "@inertiajs/svelte";
    import PaginationButtons from "./PaginationButtons.svelte";

    export let animes = [];
    export let user;
    export let selectedStatus;
    export let routes = {};

</script>

<Layout paddingSize={"1rem"}>

    <div class="wrapper">

        <div class="user-info max-width"><div class="content">

            <div>
                <h2>{user.name}</h2>
                <p style="color: var(--body-secondary-color);">Total watchlisted: {user.totalWatchlist}</p>
            </div>
    
        </div></div>
    
        <div class="watchlist-button-wrapper max-width"><div class="content">
    
            <a href="./watchlist?status=watching" use:inertia class:active={selectedStatus === "watching"}>Watching</a>
            <a href="./watchlist?status=planning" use:inertia class:active={selectedStatus === "planning"}>Planning</a>
            <a href="./watchlist?status=completed" use:inertia class:active={selectedStatus === "completed"}>Completed</a>
            <a href="./watchlist?status=paused" use:inertia class:active={selectedStatus === "paused"}>Paused</a>
            <a href="./watchlist?status=dropped" use:inertia class:active={selectedStatus === "dropped"}>Dropped</a>
    
        </div></div>

        <div class="watchlist-anime-wrapper max-width"><div class="content">

            <AnimeGrid animes={animes.data} oneRow={false} url={routes["anime-show"]}/>

        </div></div>

        {#if animes.last_page > 1}
            <div class="max-width"><div class="content" style="display: flex; justify-content: center;">
                <PaginationButtons data={animes} selectedStatus={selectedStatus} />
            </div></div>
        {/if}


    </div>

</Layout>

<style>

    .wrapper {
        display: flex; gap: var(--layout-padding);
        flex-direction: column;
    }

    .max-width {
        display: flex;
        justify-content: center;
    }

    .max-width > .content {
        width: min(50rem, 100%);
    }

    .watchlist-button-wrapper {
        border-bottom: 1px solid var(--body-tertiary-bg);

        margin-left: -1rem;
        width: calc(100% + 2rem);
    }
    .watchlist-button-wrapper > .content {
        display: flex;
        overflow-x: auto;
        padding: 0 var(--layout-padding);
    }

    .watchlist-button-wrapper a {
        display: block;
        padding: .25rem .5rem;

        color: var(--body-secondary-color);
        text-decoration: none;

        border: 1px solid transparent;
        border-bottom: none;
        border-radius: .5rem .5rem 0 0;

        transition: border 200ms;
    }
    .watchlist-button-wrapper a:hover {
        color: var(--body-color);
    }
    .watchlist-button-wrapper a.active {
        color: var(--body-color);
        border: 1px solid var(--body-tertiary-bg);
        border-bottom: none;

    }

    @media only screen and (max-width: 37.5rem) {
        .watchlist-button-wrapper {
            border-bottom: 1px solid var(--body-tertiary-bg);

            margin-left: -.5rem;
            width: calc(100% + 1rem);
        }

        .wrapper {
            gap: calc(var(--layout-padding) / 2);
        }

        .watchlist-button-wrapper .content {
            padding: 0 calc(var(--layout-padding) / 2);
        }
    }

</style>