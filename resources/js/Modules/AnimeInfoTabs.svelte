<script>

    export let tabs = [];

</script>

<div class="tabs">

    {#each tabs as tab}
        {#if typeof tab.val === "string" || typeof tab.val === "number"}
            <div class="tab">
                {#if tab.icon}
                    <i class="fi fi-{tab.icon}"></i>
                {/if}
                <p>{tab.val}</p>
            </div>
        {/if}
    {/each}

</div>

<style>

    .tabs {
        display: flex;
        gap: .25rem;
        width: max-content;
        border-radius: .5rem;
        overflow: hidden;
    }

    .tab {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: 17px;
        padding: .25rem .5rem;

        background-color: var(--app-anime-info-tabs-bg);
    }

</style>