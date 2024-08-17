<script>
    import { inertia } from "@inertiajs/svelte";

    export let data = {};
    export let selectedStatus;

</script>

<div class="wrapper">

    {#if (data.current_page - 2) >= 1}
        <a href="./watchlist?status={selectedStatus}&page={(data.current_page - 2)}" use:inertia>{(data.current_page - 2)}</a>
    {/if}
    {#if (data.current_page - 1) >= 1}
        <a href="./watchlist?status={selectedStatus}&page={(data.current_page - 1)}" use:inertia>{(data.current_page - 1)}</a>
    {/if}
    <a href="./watchlist?status={selectedStatus}&page={data.current_page}" use:inertia class="active">{data.current_page}</a>
    {#if (data.current_page + 1) <= data.last_page}
        <a href="./watchlist?status={selectedStatus}&page={(data.current_page + 1)}" use:inertia>{(data.current_page + 1)}</a>
    {/if}
    {#if (data.current_page + 2) <= data.last_page}
        <a href="./watchlist?status={selectedStatus}&page={(data.current_page + 2)}" use:inertia>{(data.current_page + 2)}</a>
    {/if}

</div>

<style>

    .wrapper {
        display: flex;

        border: 1px solid var(--body-tertiary-bg);
        border-radius: .5rem;   
    
        overflow: hidden;
    }

    .wrapper a {
        display: grid;
        place-items: center;

        height: 2rem;
        aspect-ratio: 1;

        color: var(--body-secondary-color);
        text-decoration: none;
    }
    .wrapper a:not(:last-of-type) {border-right: 1px solid var(--body-tertiary-bg);}

    .wrapper a.active, .wrapper a:hover {
        background-color: var(--body-secondary-bg);
        color: var(--body-color);
    }

</style>