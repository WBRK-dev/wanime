<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ config("app.url") }}/index.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{config("app.url")}}/cookies.js"></script>
    <link rel="manifest" href="{{config("app.url")}}/manifest.json">

    {{-- Js modules --}}
    <script src="{{config("app.url")}}/wanime-style-1/modules-js/account-dropdown.js"></script>
    <script src="{{config("app.url")}}/wanime-style-1/modules-js/search.js"></script>

    @include("layout.hit")
    @yield("head")
    <title>WAnime{{ isset($page_title) ? " - $page_title" : "" }}</title>
</head>
<body data-bs-theme="dark" class="d-flex flex-column overflow-x-hidden" style="min-height: 100vh; min-height: 100dvh;">
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
