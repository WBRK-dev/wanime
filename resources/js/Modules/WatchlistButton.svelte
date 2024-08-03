<script>

    import { onMount } from "svelte";
    import { page } from '@inertiajs/svelte';

    import clickOutside from "../Utils/ClickOutside.js";
    import Button from "./Button.svelte";

    export let anime;
    export let style = "rounded";
    export let theme = "primary";
    export let dropdownPos = "bottom-right";
    export let initialStatus = undefined;

    const watchlistStatusLabels = {"watching": "Watching", "planning": "Planning", "completed": "Completed", "paused": "Paused", "dropped": "Dropped"};
    let showDropdown = false;
    let status = undefined;

    onMount(() => {
        if (initialStatus) status = initialStatus;
    });

    const updateWatchlist = selectedStatus => {
        const oldStatus = status;
        status = selectedStatus;
        showDropdown = false;

        fetch(`/api/watchlist/${anime.id}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                _token: $page.props.csrf_token,
                status: selectedStatus || "remove"
            })
        }).then(res => {
            if (!res.ok) {
                status = oldStatus;
                console.error("Failed to update watchlist status.");
            }
        });
    }

</script>

<div class="wrapper" data-dropdown-pos={dropdownPos} data-style={style} use:clickOutside on:click_outside={() => showDropdown = false}>

    <Button title={(status ? watchlistStatusLabels[status] : "Watchlist")} icon={"sr-caret-down"} style={style} theme={theme} iconPos={"right"} on:click={() => showDropdown = !showDropdown} />

    <div class="dropdown" class:hide={!showDropdown}>

        {#each Object.keys(watchlistStatusLabels) as statuss}
            <button on:click={() => updateWatchlist(statuss)} class="item" class:active={status === statuss}>{watchlistStatusLabels[statuss]}</button>
        {/each}

        <div class="seperator"></div>

        <button on:click={() => updateWatchlist(undefined)} class="item" disabled={(status === undefined)}>Remove</button>

    </div>

</div>

<style>

    .wrapper {
        position: relative;
    }

    .dropdown {
        position: absolute;

        width: 16rem;
        padding: .5rem 0;

        background-color: var(--body-bg);
        border: .25rem solid var(--body-tertiary-bg);
        border-radius: .75rem;

        transition: opacity 200ms, transform 200ms;
    }

    .dropdown.hide { opacity: 0; }

    .wrapper[data-dropdown-pos="bottom-right"] .dropdown {
        top: calc(100% + .5rem); right: 0;
    }
    .wrapper[data-dropdown-pos="bottom-right"] .dropdown.hide { transform: scale(.8) translate(10%, -10%); }


    .dropdown .item {
        all: unset;

        display: block;
        padding: .25rem 1rem;
        width: 100%;
        box-sizing: border-box;

        color: var(--body-text);
        font-weight: 500;

        user-select: none;
        cursor: pointer;
        transition: background-color 200ms;
    }
    .dropdown .item:hover:not([disabled]) {
        background-color: var(--body-hover-bg);
    }
    .dropdown .item.active {background-color: var(--primary-bg);}
    .dropdown .item.active:hover {background-color: var(--primary-bg);}

    .dropdown .item[disabled] {
        color: var(--body-tertiary-color);
        cursor: not-allowed;
    }

    .dropdown .seperator {
        padding: .5rem 0;
        width: 100%;
        box-sizing: border-box;

        position: relative;
    }
    .dropdown .seperator::before {
        content: "";

        position: absolute;
        top: 50%; left: 1rem;
        transform: translateY(-50%);

        width: calc(100% - 2rem);
        height: .125rem;

        background-color: var(--body-tertiary-bg);
    }

    

</style>