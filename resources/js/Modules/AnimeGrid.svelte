<script>
    import AnimeCard from "./AnimeCard.svelte";


    export let title = '';
    export let animes = [];
    export let isWatchCard = false;

</script>

<div class="wrapper">

    <h3>{title}</h3>

    <div class="grid">

        {#each animes as anime}
            <div class="animecard-wrapper"><AnimeCard anime={anime} isWatchCard={isWatchCard} /></div>
        {/each}

    </div>

</div>

<style>

    .animecard-wrapper {
        margin-top: .5rem;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(10rem, 1fr));
        column-gap: .5rem;

        grid-template-rows: 1fr;
        grid-auto-rows: 0;
        overflow: hidden;
    }

    @media only screen and (max-width: 1000px) {
        .grid {
            grid-template-rows: 1fr;
            grid-auto-rows: 0;
        }
    }

</style>