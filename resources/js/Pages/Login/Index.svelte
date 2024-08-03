<script>
    import { router } from '@inertiajs/svelte'
  
    let values = {
        email: null,
        password: null,
    }
  
    function handleSubmit() {
        router.post('/login', values)
    }
</script>

<form on:submit|preventDefault={handleSubmit}>
    <label for="email">Email:</label>
    <input id="email" bind:value={values.email}>

    <label for="password">Password:</label>
    <input id="password" bind:value={values.password} type="password">

    <button type="submit">Submit</button>
</form>