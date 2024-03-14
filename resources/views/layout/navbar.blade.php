{{-- <nav class="navbar navbar-expand-md bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ $_ENV["APP_URL"] }}/">WAnime</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item"><a class="nav-link {{ (Request::is('subscriptions') ? 'active' : '') }}" aria-current="page" href="{{ $_ENV["APP_URL"] }}/subscriptions">Subscriptions</a></li>
                <li class="nav-item"><a class="nav-link {{ (Request::is('anime') ? 'active' : '') }}" aria-current="page" href="{{ $_ENV["APP_URL"] }}/">Anime</a></li>
            </ul>
            <form class="d-flex me-md-2 mb-2 mb-md-0" role="search" action="{{ $_ENV["APP_URL"] }}/search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            @if (Auth::check())
                <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-md-end">
                        <li><a class="dropdown-item" href="{{ $_ENV["APP_URL"] }}/watchlist">WatchList</a></li>
                        <li><a class="dropdown-item disabled" href="{{ $_ENV["APP_URL"] }}/account/requests">My Requests</a></li>

                        @admin
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ $_ENV["APP_URL"] }}/admin">Admin Panel</a></li>
                            <li><a class="dropdown-item" href="{{ $_ENV["APP_URL"] }}/admin/registrations">Registrations</a></li>
                        @endadmin
                        
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ $_ENV["APP_URL"] }}/account">Account</a></li>
                        <li><a class="dropdown-item" href="{{ $_ENV["APP_URL"] }}/account/settings">Settings</a></li>
                        <li><form action="{{ $_ENV["APP_URL"] }}/logout" method="post">@csrf<button class="dropdown-item">Logout</button></form></li>
                    </ul>
                </div>
            @else
                <form action="{{ $_ENV["APP_URL"] }}/account">
                    <button class="btn btn-success w-100 w-lg-auto">Login</button>
                </form>
            @endif
        </div>
    </div>
</nav> --}}

<nav class="w-header">
    <a href="{{config("app.url")}}/" class="logo">WAnime</a>

    @auth
        <div class="right">

            <div class="account" onclick="toggleAccountDropdown()">
                <p class="name">{{ Auth::user()->name }}</p>
                <i class="fi fi-sr-caret-down"></i>
            </div>
        
        </div>
    @endauth

</nav>

@auth
    <div class="account-dropdown">
                    
        <p class="fw-bold">{{ Auth::user()->name }}</p>
        <p>{{ Auth::user()->email }}</p>

        <div class="account-dropdown-item-list">

            <a class="account-dropdown-item" href="{{ config("app.url") }}/account"><i class="fi fi-sr-user"></i><p>Account</p></a>
            <a class="account-dropdown-item" href="{{ config("app.url") }}/watchlist"><i class="fi fi-sr-list"></i><p>Watchlist</p></a>
            <a class="account-dropdown-item" href="{{ config("app.url") }}/account/settings"><i class="fi fi-sr-settings"></i><p>Settings</p></a>

            @admin
                <a class="account-dropdown-item" href="{{ config("app.url") }}/admin"><i class="fi fi-sr-api"></i><p>Admin Panel</p></a>
                <a class="account-dropdown-item" href="{{ config("app.url") }}/admin/registrations"><i class="fi fi-sr-api"></i><p>Registrations</p></a>
            @endadmin

        </div>

        <a href="#" class="logout"><p>Logout</p><i class="fi fi-sr-arrow-right"></i></a>

    </div>
@endauth