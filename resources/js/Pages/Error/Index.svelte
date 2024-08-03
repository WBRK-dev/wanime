<script>

    import Layout from '../../Layout/Main/Index.svelte';

    export let code = 0;

</script>

<Layout>

    <div class="wrapper">

        <p class="code">{code}</p>

        <p class="message">Something went wrong. Please try again later.</p>

    </div>

</Layout>

<style>

    .wrapper {
        position: relative;
        /* height: calc(100vh - 4rem); */
        height: 100%;
    }

    .code {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        
        font-size: 30rem;
        font-weight: 800;

        background-image: linear-gradient(to bottom, #ffffff00, #ffffff2d);
        -webkit-background-clip: text;
        color: transparent;
    }

    .message {
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);

        font-size: 2rem;
        font-weight: 700;
    }

</style>