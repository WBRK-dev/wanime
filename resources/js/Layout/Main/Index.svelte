<script>
    import Footer from "./Modules/Footer.svelte";
    import Navbar from "./Modules/Navbar.svelte";

    export let padding = true;
    export let paddingSize;

    export let enablePosRelative = false;

</script>

<main class:relative={enablePosRelative}>
    <Navbar/>

    <div class="content" style="--layout-padding: {paddingSize ? paddingSize : (padding ? "2rem": "0")};" data-dyn-padding={padding}>
        <slot/>
    </div>

    <Footer/>
</main>

<style>

    main {
        display: flex;
        flex-direction: column;

        min-height: 100vh;
        min-height: 100dvh;
    }

    .content {
        flex-grow: 1;
        padding: var(--layout-padding);
    }

    @media only screen and (max-width: 37.5rem) {
        .content[data-dyn-padding="true"] {
            padding: calc(var(--layout-padding) / 2);
        }
    }

    main.relative .content {
        position: relative;
    }

</style>