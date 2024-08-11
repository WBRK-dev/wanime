<script>
    import { createEventDispatcher } from "svelte";


    export let episodes = [];
    export let current = 0;

    const dispatch = createEventDispatcher();
    let buttons = [];
    let wrapperElem;

    // $: current, scrollIntoView();

    // const scrollIntoView = () => {
    //     console.log(buttons[current]?.offsetTop - wrapperElem?.offsetTop - convertRemToPixels(0.5));
    //     wrapperElem?.scroll(0, buttons[current]?.offsetTop - wrapperElem?.offsetTop - convertRemToPixels(0.5));
    // }

    // const convertRemToPixels = (rem) => {
    //     const rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize);
    //     return rem * rootFontSize;
    // }

</script>

<div class="wrapper" class:list={episodes.length <= 24} bind:this={wrapperElem}>

    {#each episodes as episode, i}
        
        <button on:click={() => dispatch("click", i)} class:active={i === current} bind:this={buttons[i]}>
            {episode.number}
        </button>

    {/each}

</div>

<style>

    .wrapper {
        padding: .5rem;

        background-color: var(--body-secondary-bg);
        border-radius: .5rem;

        max-height: 31.25rem;
        overflow-y: auto;
    }

    .wrapper:not(.list) {
        display: grid; gap: .25rem;
        grid-template-columns: repeat(auto-fill, minmax(3rem, 1fr));
    }

    .wrapper:not(.list) button {
        padding: .1rem 0;

        border: none;
        border-radius: .25rem;
        background-color: var(--app-episode-button-bg);
        color: var(--app-episode-button-color);

        cursor: pointer;
    }
    .wrapper:not(.list) button:hover {background-color: var(--app-episode-button-bg-hover);}
    .wrapper:not(.list) button.active {background-color: var(--app-episode-button-bg-active);}

</style>