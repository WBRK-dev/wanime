<script>

    import { page, inertia, router } from '@inertiajs/svelte';

    import clickOutside from "../../../Utils/ClickOutside.js";

    let showUserPopup = false;

    const logout = () => {
        router.post("/logout");
    }

</script>

<div class="navbar">
    <a href="/" use:inertia class="logo">WAnime</a>

    <div class="right">


        {#if $page.props.auth?.user}

            <div class="user-dropdown-wrapper" use:clickOutside on:click_outside={() => showUserPopup = false}>

                <button class="user-button" on:click={() => showUserPopup = !showUserPopup}><p>{$page.props.auth.user.name}</p><i class="fi fi-sr-caret-down"></i></button>

                <div class="user-dropdown" class:show={showUserPopup}>

                    <div class="info">
                        <p class="big">{$page.props.auth.user.name}</p>
                        <p>{$page.props.auth.user.email}</p>
                    </div>

                    <div class="button-list">
                        <button class="list-item wip-bg" style="color: transparent;"><i class="fi fi-sr-user"></i><p>Account</p></button>
                        <a href="/user/{$page.props.auth.user.id}/watchlist" use:inertia class="list-item"><i class="fi fi-sr-rectangle-list"></i><p>Watchlist</p></a>
                        <button class="list-item wip-bg" style="color: transparent;"><i class="fi fi-sr-settings"></i><p>Settings</p></button>
                        {#if $page.props.auth}
                            <button class="list-item wip-bg" style="color: transparent;"><i class="fi fi-sr-settings"></i><p>Settings</p></button>
                        {/if}
                    </div>

                    <button class="logout-button" on:click={logout}><p>Logout</p><i class="fi fi-sr-arrow-right"></i></button>

                </div>

            </div>

        {:else}
            
            <a href="/login" use:inertia class="user-button">Login</a>
            
        {/if}

    </div>
</div>

<style>

    .navbar {
        display: flex; gap: .5rem;
        align-items: center;

        position: relative;

        padding: 0 .5rem 0 1rem;
        height: 4rem;
        
        background-color: var(--app-navbar-bg);
    }

    .navbar .logo {
        font-size: 1.5rem;
        font-weight: 700;

        text-decoration: none;
        color: var(--body-color);
    }


    .right {
        margin-left: auto;
        display: flex; gap: .5rem;
        align-items: center;
    }

    .user-button {
        display: flex; gap: .25rem;
        align-items: center;

        padding: .25rem .5rem;

        background-color: transparent;
        border: none;
        border-radius: .5rem;

        color: var(--body-color);
        text-decoration: none;

        cursor: pointer;
    }
    .user-button:hover {
        background-color: var(--app-transparent-hover-bg);
    }

    .user-dropdown-wrapper .user-dropdown {
        display: flex; gap: 1rem;
        flex-direction: column;

        position: absolute;
        top: calc(100% + .5rem); right: .5rem;
        width: min(18.75rem, 100%);
        z-index: 3;

        transform: scale(0.9);
        opacity: 0;

        background-color: var(--body-secondary-bg);
        border: 2px solid var(--body-tertiary-bg);
        border-radius: .5rem;

        padding: 1rem .5rem;
        box-sizing: border-box;

        transition: opacity 200ms, transform 200ms;
    }
    .user-dropdown-wrapper .user-dropdown.show {
        transform: scale(1);
        opacity: 1;
    }

    .user-dropdown-wrapper .user-dropdown .info {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .user-dropdown-wrapper .user-dropdown .info p {color: var(--body-secondary-color);}
    .user-dropdown-wrapper .user-dropdown .info p.big {
        font-size: 1.1rem;
        font-weight: 700;
        color: inherit;
    }

    .user-dropdown-wrapper .user-dropdown .button-list {
        display: flex; gap: .25rem;
        flex-direction: column;
    }

    .user-dropdown-wrapper .user-dropdown .button-list .list-item {
        display: flex; gap: .5rem;
        align-items: center;

        padding: .5rem 1rem;

        background-color: var(--body-tertiary-bg);
        border: none;
        border-radius: 5rem;

        color: var(--body-color);
        font-size: 1rem;
        text-decoration: none;

        cursor: pointer;
    }

    .user-dropdown-wrapper .user-dropdown .logout-button {
        display: flex; gap: .5rem;
        align-items: center;
        justify-content: end;

        background-color: transparent;
        border: none; border-radius: 0;

        color: var(--body-secondary-color);

        cursor: pointer;
    }
    .user-dropdown-wrapper .user-dropdown .logout-button:hover {color: var(--body-color);}


</style>