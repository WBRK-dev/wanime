<nav class="w-header">
    <a href="{{config("app.url")}}/" class="logo">WAnime</a>

    <div class="right">


        <div class="search">
            <form action="search" method="get">
                <input type="text" placeholder="Search..." name="search">
            </form>
            <i class="fi fi-sr-search"></i>
        </div>

        <div class="search-button">
            <button onclick="search.toggle()"><i class="fi fi-sr-search"></i></button>
        </div>


        @if (Auth::check())

            <button class="account" onclick="toggleAccountDropdown()">
                <p class="name">{{ Auth::user()->name }}</p>
                <i class="fi fi-sr-caret-down"></i>
            </button>
        
        @else
        
            <a class="account no-a" href="{{config("app.url")}}/login">
                <p class="name">Login</p>
            </a>

        @endif
    </div>

</nav>

@if (Auth::check())
    <div class="account-dropdown">
                    
        <p class="fs-5 fw-bold text-center mt-2">{{ Auth::user()->name }}</p>
        <p class="text-center">{{ Auth::user()->email }}</p>

        <div class="account-dropdown-item-list mt-3">

            <a class="account-dropdown-item" href="{{ config("app.url") }}/account"><i class="fi fi-sr-user"></i><p>Account</p></a>
            <a class="account-dropdown-item" href="{{ config("app.url") }}/watchlist"><i class="fi fi-sr-rectangle-list"></i><p>Watchlist</p></a>
            {{-- <a class="account-dropdown-item" href="{{ config("app.url") }}/account/settings"><i class="fi fi-sr-settings"></i><p>Settings</p></a> --}}
            <a class="account-dropdown-item" href="#"><i class="fi fi-sr-settings"></i><p>Settings</p></a>

            @admin
                <a class="account-dropdown-item" href="{{ config("app.url") }}/admin"><i class="fi fi-sr-api"></i><p>Admin Panel</p></a>
                <a class="account-dropdown-item" href="{{ config("app.url") }}/admin/registrations"><i class="fi fi-sr-api"></i><p>Registrations</p></a>
            @endadmin

        </div>

        <form action="{{ $_ENV["APP_URL"] }}/logout" method="post">
            @csrf
            <button class="logout"><p>Logout</p><i class="fi fi-sr-arrow-right"></i></button>
        </form>

    </div>
@endif

<div class="search-dropdown">
    <form action="search" method="get">
        <input type="text" placeholder="Search..." name="search">
    </form>
    <i class="fi fi-sr-search"></i>
</div>