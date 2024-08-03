<script>
    import Footer from "./Modules/Footer.svelte";
    import Navbar from "./Modules/Navbar.svelte";

    export let padding = true;
    export let paddingSize;

</script>

<main>
    <Navbar/>

    <div class="content" style="--padding: {paddingSize ? paddingSize : (padding ? "2rem": "0")};" data-dyn-padding={padding}>
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
        padding: var(--padding);
    }

    @media only screen and (max-width: 600px) {
        .content[data-dyn-padding="true"] {
            padding: calc(var(--padding) / 2);
        }
    }

</style>