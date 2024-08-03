<script>
    import { onDestroy, onMount } from "svelte";
    import AnimeInfoTabs from "../../Modules/AnimeInfoTabs.svelte";
    import { inertia } from "@inertiajs/svelte";

    export let animes = [];

    let spotlightTimeout;
    let activeSlide = 0;
    let slideDirection = "";
    let slidable = true;

    onMount(() => {
        spotlightTimeout = setTimeout(nextSlide, 5000);
    });

    onDestroy(() => {
        clearTimeout(spotlightTimeout);
    });

    const nextSlide = async () => {
        if (!animes.length || !slidable) return;
        slidable = false; clearTimeout(spotlightTimeout);

        activeSlide = activeSlide + 1 < animes.length ? activeSlide + 1 : 0;
        slideDirection = "forward";

        await new Promise(r => setTimeout(r, 1000));
        slidable = true;

        spotlightTimeout = setTimeout(nextSlide, 5000);
    };

    const prevSlide = async () => {
        if (!animes.length || !slidable) return;
        slidable = false; clearTimeout(spotlightTimeout);

        activeSlide = activeSlide - 1 >= 0 ? activeSlide - 1 : animes.length - 1;
        slideDirection = "backward";

        await new Promise(r => setTimeout(r, 1000));
        slidable = true;

        spotlightTimeout = setTimeout(nextSlide, 5000);
    };


    const slideIsLeft = (i) => {
        return ((i + 1 < animes.length && i + 1 === activeSlide) || (i + 1 >= animes.length && 0 === activeSlide));
    };

    const slideIsRight = (i) => {
        return ((i - 1 >= 0 && i - 1 === activeSlide) || (i - 1 < 0 && animes.length - 1 === activeSlide));
    };

</script>

<div class="wrapper">

    {#each animes as anime, i}
        <div class="item" class:slide-active={(i === activeSlide || (slideIsLeft(i) && slideDirection === "forward") || (slideIsRight(i) && slideDirection === "backward"))} class:slide-left={((i + 1 < animes.length && i + 1 === activeSlide) || (i + 1 >= animes.length && 0 === activeSlide))} class:slide-right={((i - 1 >= 0 && i - 1 === activeSlide) || (i - 1 < 0 && animes.length - 1 === activeSlide))}>

            <div class="info-wrapper">
                <p class="secondary">#{i + 1} Spotlight</p>
                <h2>{anime.name}</h2>
                <div style="display: flex; gap: .5rem;">
                    <div id="details"><AnimeInfoTabs tabs={anime.otherInfo.map(obj => { return {val: obj}; })} /></div>
                    <AnimeInfoTabs tabs={[{icon: "sr-subtitles", val: anime.episodes.sub || 0}, {icon: "sr-microphone", val: anime.episodes.dub || 0}]} />
                </div>
                <p class="secondary description">
                    {anime.description}
                </p>
                <div class="buttons">
                    <a href="/watch?id={anime.id}" class="primary" use:inertia><i class="fi fi-sr-play-circle"></i>Watch Now</a>
                    <a href="/anime?id={anime.id}" class="secondary" use:inertia><i class="fi fi-sr-info"></i>Details</a>
                </div>
            </div>

            <div class="img-wrapper">
                <img src="{anime.poster}" alt="">
            </div>

            <div class="fade-effect"></div>

        </div>
    {/each}

    <div class="spotlight-buttons">

        <button on:click={nextSlide}><i class="fi fi-sr-angle-small-right"></i></button>
        <button on:click={prevSlide}><i class="fi fi-sr-angle-small-left"></i></button>

    </div>

</div>

<style>

    .wrapper {
        position: relative;

        height: 25rem;

        overflow: hidden;
    }

    .item {
        display: grid;
        grid-template-columns: 40% 60%;
        
        position: absolute;
        top: 0; left: 0%;
        z-index: 0;

        width: 100%; height: 100%;
        transition: left 1000ms;
    }

    .item.slide-active {
        z-index: 1;
    }

    .item.slide-left {
        left: -100%;
    }
    .item.slide-right {
        left: 100%;
    }

    .info-wrapper {
        padding: 2rem;
        box-sizing: border-box;

        display: flex;
        flex-direction: column;
        justify-content: end;

        background-color: var(--body-bg);
    }

    .info-wrapper h2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;

        margin-bottom: .5rem;
    }

    .info-wrapper .secondary {
        color: var(--body-secondary-color);
    }

    .info-wrapper .description {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;

        margin-top: .5rem;
    }

    .info-wrapper .buttons {
        display: flex; gap: .5rem;
        margin-top: .5rem;
    }

    .info-wrapper .buttons a {
        all: unset;

        display: flex; gap: .5rem;
        align-items: center;
        
        text-decoration: none;
        color: #fff;
        font-weight: 500;

        padding: .5rem 1rem;

        border-radius: 50px;
        background-color: var(--primary-bg);

        cursor: pointer;
        transition: background-color 250ms;
    }
    .info-wrapper .buttons a:hover {
        background-color: var(--primary-hover-bg);
    }
    .info-wrapper .buttons a.secondary {background-color: var(--secondary-bg);}
    .info-wrapper .buttons a.secondary:hover {background-color: var(--secondary-hover-bg);}

    .item .img-wrapper img {
        display: block;
        width: 100%; height: 25rem;
        object-fit: cover;
    }

    .item .fade-effect {
        position: absolute;
        top: 0; left: 40%;
        width: 6rem; height: 100%;

        background: linear-gradient(to right, var(--body-bg), rgba(var(--body-bg-rgb), 0));
    }


    .spotlight-buttons {
        display: flex; gap: .5rem;
        flex-direction: column;

        position: absolute;
        bottom: 1rem; right: 1rem;
        z-index: 2;
    }

    .spotlight-buttons button {
        padding: .5rem;

        border: none;
        border-radius: .25rem;
        background-color: var(--body-bg);

        font-size: 1rem;
        color: var(--body-secondary-color);

        cursor: pointer;
        transition: background-color 250ms;
    }
    .spotlight-buttons button:hover {
        background-color: var(--body-tertiary-bg);
    }


    @media only screen and (max-width: 1100px) {
        #details {
            display: none;
        }
    }

    @media only screen and (max-width: 1000px) {
        .description {
            display: none !important;
        }

        .wrapper {
            height: 50vh;
            min-height: 15rem;
            max-height: 20rem;
        }

        .item {
            display: block;
        }

        .item .info-wrapper {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            padding: 1rem;
            z-index: 1;

            background-color: rgba(var(--body-bg-rgb), .75);
        }

        .item .img-wrapper {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
        }

        .fade-effect {
            display: none;
        }
    }

</style>