<script>

    import Layout from "../../Layout/Main/Index.svelte";

    import { page, useForm } from '@inertiajs/svelte';
  
    let form = useForm({
        email: null,
        password: null,
    });
    let showPassword = false;
  
    const handleSubmit = async () => {
        $form.clearErrors();
        $form.post($page.props.common.routes.login, {onSuccess: () => console.log("test1")});
    }
</script>

<Layout>

    <form on:submit|preventDefault={handleSubmit}>

        <input name="email" bind:value={$form.email} placeholder="Email" type="email" required>

        {#if $form.errors.email}
            <p class="form-error">{$form.errors.email}</p>
        {/if}
    
        <div class="input-wrapper">
            {#if showPassword}
                <input name="password" bind:value={$form.password} type="text" placeholder="Password" required>
            {:else}
                <input name="password" bind:value={$form.password} type="password" placeholder="Password" required>
            {/if}
            <button class="input-button" type="button" on:click={() => showPassword = !showPassword}><i class="fi fi-sr-eye{showPassword ? "-crossed" : ""}"></i></button>
        </div>

        {#if $form.errors.password}
            <p class="form-error">{$form.errors.password}</p>
        {/if}
    
        <button class="submit" type="submit" disabled={$form.processing}><p>Submit</p></button>
    </form>

</Layout>

<style>

    form {
        display: flex; gap: .5rem;
        flex-direction: column;
        align-items: center;
    }

    .input-wrapper {
        display: flex;
        align-items: stretch;

        width: min(18.75rem, 100%);

        position: relative;
    }
    input {
        width: min(18.75rem, 100%);
        padding: .5rem .75rem;
        box-sizing: border-box;

        background-color: transparent;
        border: 1px solid var(--body-tertiary-bg);
        border-radius: .5rem;

        color: var(--body-color);
        font-size: 1rem;

        outline: 0px solid rgba(var(--body-tertiary-bg-rgb), .7);
        transition: outline 200ms;
    }
    .input-wrapper > input {
        width: 1rem; 
        flex-grow: 1;

        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .input-wrapper > button.input-button {
        display: grid;
        place-items: center;

        background-color: transparent;
        border: 1px solid var(--body-tertiary-bg);
        border-left: none;
        border-top-right-radius: .5rem;
        border-bottom-right-radius: .5rem;

        color: var(--body-color);
        font-size: 1rem;

        aspect-ratio: 1;
        cursor: pointer;
        transition: background-color 200ms;
    }
    .input-wrapper > button.input-button:hover {background-color: var(--body-secondary-bg);}

    input:focus {outline: 4px solid rgba(var(--body-tertiary-bg-rgb), .7);}

    button.submit {
        position: relative;

        width: min(18.75rem, 100%);
        padding: .5rem;
        box-sizing: border-box;

        border: none;
        border-radius: .5rem;
        background-color: var(--primary-bg);

        color: var(--primary-color);
        font-size: 1rem;

        cursor: pointer;
        transition: background-color 200ms;
    }
    button.submit:hover {background-color: var(--primary-hover-bg);}
    button.submit[disabled] {
        background-color: var(--primary-hover-bg);
        color: var(--body-secondary-color);
    }

    button.submit::after {
        content: "";

        position: absolute;
        top: 50%; left: 50%;
        width: 1rem; aspect-ratio: 1;
        transform: translate(-50%, -50%);

        border: 2px solid #fff;
        border-right: 2px solid transparent;
        border-bottom: 2px solid transparent;
        border-radius: 50%;

        animation: buttonSpinnerLogin 1s infinite linear;

        opacity: 0;
        transition: opacity 200ms;
    }
    button.submit[disabled]::after {opacity: 1;}

    @keyframes buttonSpinnerLogin {
        0% { transform: translate(-50%, -50%) rotateZ(0deg); }
        100% { transform: translate(-50%, -50%) rotateZ(360deg); }
    }

    button.submit p {transition: opacity 200ms;}
    button.submit[disabled] p {opacity: 0;}

    p.form-error {
        color: var(--danger-bg);
    }

</style>