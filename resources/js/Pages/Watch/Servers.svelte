<script>

    import { createEventDispatcher } from "svelte";

    export let sub = [];
    export let dub = [];
    export let raw = [];
    export let selectedCategory = "";
    export let selectedServer = "";

    const dispatch = createEventDispatcher();

</script>

<div class="wrapper">

    {#if sub.length > 0}
        <div class="server-list">

            <div class="label">
                <i class="fi fi-sr-subtitles"></i>
                <p>SUB:</p>
            </div>
            <div class="servers">
                {#each sub as button}
                    <button on:click={() => dispatch("click", {category: "sub", server: button.serverName})} class:active={selectedCategory === "sub" && selectedServer === button.serverName}>{button.serverName}</button>
                {/each}
            </div>

        </div>
    {/if}

    {#if dub.length > 0}
        <div class="server-list">

            <div class="label">
                <i class="fi fi-sr-microphone"></i>
                <p>DUB:</p>
            </div>
            <div class="servers">
                {#each dub as button}
                    <button on:click={() => dispatch("click", {category: "dub", server: button.serverName})} class:active={selectedCategory === "dub" && selectedServer === button.serverName}>{button.serverName}</button>
                {/each}
            </div>

        </div>
    {/if}

    {#if raw.length > 0}
        <div class="server-list">

            <div class="label">
                <i class="fi fi-sr-file"></i>
                <p>RAW:</p>
            </div>
            <div class="servers">
                {#each raw as button}
                    <button on:click={() => dispatch("click", {category: "raw", server: button.serverName})} class:active={selectedCategory === "raw" && selectedServer === button.serverName}>{button.serverName}</button>
                {/each}
            </div>

        </div>
    {/if}

    {#if sub.length === 0 && dub.length === 0 && raw.length === 0}
        <div class="spinner-wrapper"><div class="spinner"></div></div>
    {/if}

</div>

<style>

    .wrapper {
        background-color: var(--body-secondary-bg);
        border-radius: .5rem;
    }

    .server-list {
        display: flex;
        align-items: center;

        padding: 1rem;
    }
    .server-list:not(:last-of-type) {border-bottom: 1px solid var(--body-tertiary-bg);}

    .server-list .label {
        display: flex; gap: .5rem;
        align-items: center;

        width: 7.5rem;
    }
    .server-list .label p {
        margin-bottom: -.1rem;
    }

    .server-list .servers {
        display: flex; gap: .5rem;
        align-items: center;
    }
    .server-list .servers button {
        display: block;

        padding: .25rem 1rem;

        color: var(--app-episode-button-color);
        background-color: var(--app-episode-button-bg);
        border: none;
        border-radius: .5rem;

        cursor: pointer;
    }
    .server-list .servers button:hover {background-color: var(--app-episode-button-bg-hover);}
    .server-list .servers button.active {background-color: var(--app-episode-button-bg-active);}

    .spinner-wrapper {
        display: flex;
        justify-content: center;

        padding: 1rem;
    }

    .spinner-wrapper .spinner {
        height: 1.5rem;
        aspect-ratio: 1;

        border: .1rem solid #fff;
        border-bottom: .1rem solid transparent;
        border-right: .1rem solid transparent;
        border-radius: 50%;

        animation: spinner 1s infinite linear;
    }

    @keyframes spinner {
        0% {transform: rotateZ(0deg);}
        100% {transform: rotateZ(360deg);}
    }

</style>