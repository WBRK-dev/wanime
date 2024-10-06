<script>

    export let characters;
    export let promotionalMaterial;
    export let extraInfo;

</script>

<div class="wrapper">

    <div class="char-video-wrapper">

        <div class="char-wrapper">

            <h4>Characters & Voice Actors</h4>

            <div class="char-wrapper-wrapper">

                {#each characters as char}
                    <div class="char-item">
                        <div class="left">
                            <img src={char.character.poster} alt="">
                            <div class="info">
                                <p class="name">{char.character.name}</p>
                                <p class="cast">{char.character.cast}</p>
                            </div>
                        </div>
                        <div class="right">
                            <div class="info">
                                <p class="name">{char.voiceActor.name}</p>
                                <p class="cast">{char.voiceActor.cast}</p>
                            </div>
                            <img src={char.voiceActor.poster} alt="">
                        </div>
                    </div>
                {/each}

            </div>

        </div>

        <div class="video-wrapper">

            <h4>Promotional Videos</h4>

            <div class="video-wrapper-wrapper">

                {#each promotionalMaterial as video}
                    <button class="video" on:click={() => alert("Coming soon")}>
                        <img src={video.thumbnail} alt="">
                        <p>{video.title}</p>
                    </button>
                {/each}

            </div>

        </div>

    </div>

    <div class="stats-wrapper">

        <p><span>Japenese:</span> {extraInfo.japanese}</p>
        <p><span>Synonyms:</span> {extraInfo.synonyms}</p>
        <p><span>Aired:</span> {extraInfo.aired}</p>
        <p><span>Premiered:</span> {extraInfo.premiered}</p>
        <p><span>Duration:</span> {extraInfo.duration}</p>
        <p><span>Status:</span> {extraInfo.status}</p>
        <p><span>Malscore:</span> {extraInfo.malscore}</p>
        <p><span>Genres:</span> {(typeof extraInfo.genres === "array" ? extraInfo.genres.join(", ") : extraInfo.genres || "")}</p>
        <p><span>Studios:</span> {(typeof extraInfo.studios === "array" ? extraInfo.studios.join(", ") : extraInfo.studios || "")}</p>
        <p><span>Producers:</span> {(typeof extraInfo.producers === "array" ? extraInfo.producers.join(", ") : extraInfo.producers || "")}</p>

    </div>

</div>

<style>

    .wrapper {
        display: grid;
        grid-template-columns: 1fr 31.25rem;

        background-color: var(--body-secondary-bg);

        margin-left: -2rem;
        width: calc(100% + var(--layout-padding) * 2);
    }

    .char-video-wrapper {
        display: flex; gap: 1rem;
        flex-direction: column;

        padding: 1rem;
    }

    .char-video-wrapper h4 {
        margin-bottom: .5rem;
    }

    .char-video-wrapper .char-wrapper .char-wrapper-wrapper {
        display: grid; gap: 1rem;
        grid-template-columns: repeat(auto-fill, minmax(27rem, 1fr));
    }

    .char-video-wrapper .char-wrapper .char-item {
        display: flex;
        justify-content: space-between;

        padding: .5rem;
        border-radius: .5rem;

        background-color: var(--body-tertiary-bg);
    }
    .char-video-wrapper .char-wrapper .char-item .left, .char-video-wrapper .char-wrapper .char-item .right {
        display: flex; gap: 1rem;
        align-items: center;
    }
    .char-video-wrapper .char-wrapper .char-item img {
        width: 3rem;
        border-radius: 50%;

        aspect-ratio: 1;

        object-fit: cover;
    }
    .char-video-wrapper .char-wrapper .char-item .right .info {
        display: flex;
        flex-direction: column;
        align-items: end;
    }

    .char-video-wrapper .char-wrapper .char-item .info .cast {
        color: var(--body-tertiary-color);
    }
    .char-video-wrapper .char-wrapper .char-item .info .name {
        font-weight: 700;
    }

    .char-video-wrapper .video-wrapper-wrapper {
        display: grid; gap: .5rem;
        grid-template-columns: repeat(auto-fill, minmax(14rem, 1fr));
    }

    .char-video-wrapper .video-wrapper-wrapper button {
        display: block;

        padding: 0;
        border: none;
        border-radius: .5rem;

        background-color: var(--body-tertiary-bg);

        overflow: hidden;
        cursor: pointer;
    }
    .char-video-wrapper .video-wrapper-wrapper button img {
        display: block;

        width: 100%;
        aspect-ratio: 16 / 9;

        object-fit: cover;
    }
    .char-video-wrapper .video-wrapper-wrapper button p {
        padding: .25rem .5rem;
        color: var(--body-color);
    }

    .stats-wrapper {
        display: flex; gap: .25rem;
        flex-direction: column;

        background-color: var(--body-tertiary-bg);
        padding: 1rem;
    }

    .stats-wrapper p span {font-weight: 700;}





    @media only screen and (max-width: 37.5rem) {
        .wrapper {
            margin-left: calc((var(--layout-padding) / 2) * -1);
            width: calc(100% + var(--layout-padding));
        }
    }

    @media only screen and (max-width: 62.5rem) {
        .wrapper {
            grid-template-columns: 1fr;
        }

        .wrapper .stats-wrapper {
            order: -1;
        }
    }

</style>