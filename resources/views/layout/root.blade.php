<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ $_ENV["APP_URL"] }}/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{config("app.url")}}/cookies.js"></script>
    <link rel="manifest" href="/manifest.json">
    @include("layout.hit")
    @yield("head")
    <title>WAnime{{ isset($page_title) ? " - $page_title" : "" }}</title>
</head>
<body data-bs-theme="dark" class="d-flex flex-column" style="min-height: 100vh; min-height: 100dvh;">
    <script>(localStorage.getItem("bstheme") && localStorage.getItem("bstheme") === "light") ? document.querySelector("body").setAttribute("data-bs-theme", "light") : false</script>
    @include('layout.navbar')
    
    <div class="d-flex justify-content-center flex-grow-1">
        <div style="width: min(1920px, 100%);">
            @yield('body')
        </div>
    </div>

    @include("layout.footer")

    {{-- @include("layout.newyearmessage") --}}
</body>
</html>