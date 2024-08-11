<script>
    import { page, inertia } from '@inertiajs/svelte';
</script>

<div class="navbar">
    <a href="/" use:inertia class="logo">WAnime</a>

    <div class="right">


        {#if $page.props.auth.user}
            <form action="/logout" method="post"><input type="hidden" name="_token" value="{$page.props.csrf_token}"><button>logout</button></form>
        {:else}
            <a href="/login" use:inertia class="user-btn">Login</a>
            <!-- <a href="/register" use:inertia class="user-btn">Register</a> -->
            
        {/if}

    </div>
</div>

<style>

    .navbar {
        display: flex; gap: .5rem;
        align-items: center;

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

</style>