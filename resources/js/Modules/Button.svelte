<script>
    import { inertia } from "@inertiajs/svelte";
    import { createEventDispatcher } from "svelte";
    
    const dispatch = createEventDispatcher();

    export let title;
    export let style = "rounded";
    export let theme = "primary";
    export let href = undefined;
    export let icon = undefined;
    export let iconPos = "left";

</script>

{#if href}
    <a href="{href}" use:inertia class="btn" data-style={style} data-theme={theme} data-icon-pos={iconPos}>
        {#if icon}
            <i class="fi fi-{icon}"></i>
        {/if}
        <p>{title}</p>
    </a>
{:else}
    <button class="btn" data-style={style} data-theme={theme} on:click={() => dispatch("click")} data-icon-pos={iconPos}>
        {#if icon}
            <i class="fi fi-{icon}"></i>
        {/if}
        <p>{title}</p>
    </button>
{/if}

<style>

    .btn {
        all: unset;

        display: flex; gap: .5rem;
        align-items: center;
        
        text-decoration: none;
        color: #fff;
        font-weight: 500;

        padding: .5rem 1rem;

        background-color: var(--primary-bg);

        user-select: none;
        cursor: pointer;
        transition: background-color 250ms;
    }

    .btn[data-style="rounded"] {
        border-radius: 50px;
    }
    .btn[data-style="stomped"] {
        border-radius: .5rem;
    }

    .btn[data-icon-pos="right"] {
        flex-direction: row-reverse;
    }

    .btn[data-theme="primary"] { background-color: var(--primary-bg); }
    .btn[data-theme="primary"]:hover { background-color: var(--primary-hover-bg); }
    .btn[data-theme="secondary"] { background-color: var(--secondary-bg); }
    .btn[data-theme="secondary"]:hover { background-color: var(--secondary-hover-bg); }

</style>