<div id="general">
    <div class="d-flex flex-wrap align-items-center border-bottom px-4 py-3">
        <p class="fs-5 m-0">Theme</p>

        <div class="dropdown ms-auto">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dark
            </button>
            <ul class="dropdown-menu">
                <li><button onclick="dropdownHandler(this, 'theme', 'dark')" class="dropdown-item active">Dark</button></li>
                <li><button onclick="dropdownHandler(this, 'theme', 'light')" class="dropdown-item">Light</button></li>
            </ul>
        </div>
    </div>
</div>

<div id="privacy" style="display: none;">

    <div class="d-flex flex-wrap align-items-center border-bottom px-4 py-3">
        <p class="fs-5 m-0">Account Visibility</p>

        <div class="dropdown ms-auto">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ ($privacy["visibility"] === "private") ? "Private" : "Global" }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><button onclick="dropdownHandler(this, 'visible_to_public', 'global')" class="dropdown-item {{ ($privacy["visibility"] === "global") ? "active" : "" }}">Global</button></li>
                <li><button onclick="dropdownHandler(this, 'visible_to_public', 'private')" class="dropdown-item {{ ($privacy["visibility"] === "private") ? "active" : "" }}">Private</button></li>
            </ul>
        </div>
    </div>

    <div class="d-flex flex-wrap align-items-center border-bottom px-4 py-3">
        <p class="fs-5 m-0">Save Episode Progress</p>

        <div class="dropdown ms-auto">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ ($privacy["save_episode_progress"] === "never") ? "Never" : (($privacy["save_episode_progress"] === "in_watching") ? "When in Watching" : "Always") }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><button onclick="dropdownHandler(this, 'save_episode_progress', 'always')" class="dropdown-item disabled {{ ($privacy["save_episode_progress"] === "always") ? "active" : "" }}">Always</button></li>
                <li><button onclick="dropdownHandler(this, 'save_episode_progress', 'in_watching')" class="dropdown-item {{ ($privacy["save_episode_progress"] === "in_watching") ? "active" : "" }}">When in Watching</button></li>
                <li><button onclick="dropdownHandler(this, 'save_episode_progress', 'never')" class="dropdown-item {{ ($privacy["save_episode_progress"] === "never") ? "active" : "" }}">Never</button></li>
            </ul>
        </div>
    </div>

    <div class="d-flex flex-wrap align-items-center border-bottom px-4 py-3">
        <p class="fs-5 m-0">Public Reviews</p>

        <div class="dropdown ms-auto">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ ($privacy["public_reviews"] === "public") ? "Public" : "Private" }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><button onclick="dropdownHandler(this, 'public_reviews', 'public')" class="dropdown-item {{ ($privacy["public_reviews"] === "public") ? "active" : "" }}">Public</button></li>
                <li><button onclick="dropdownHandler(this, 'public_reviews', 'private')" class="dropdown-item {{ ($privacy["public_reviews"] === "private") ? "active" : "" }}">Private</button></li>
            </ul>
        </div>
    </div>

</div>

<div id="account" style="display: none;">

    <div class="alert alert-warning m-0" role="alert">
        This does not work right now.
    </div>

    <div class="d-flex flex-wrap align-items-center border-bottom px-4 py-3">
        <p class="fs-5 m-0">Username</p>

        <button class="btn btn-secondary ms-auto disabled">Update</button>
    </div>

    <div class="d-flex flex-wrap align-items-center border-bottom px-4 py-3">
        <p class="fs-5 m-0">Email</p>

        <button class="btn btn-secondary ms-auto disabled">Update</button>
    </div>

    <div class="d-flex flex-wrap align-items-center border-bottom px-4 py-3">
        <p class="fs-5 m-0">Password</p>

        <button class="btn btn-secondary ms-auto disabled">Update</button>
    </div>

    <div class="d-flex flex-wrap align-items-center border-bottom px-4 py-3">
        <p class="fs-5 m-0">Delete Account</p>

        <button class="btn btn-danger ms-auto disabled">Delete</button>
    </div>
</div>

<div id="advanced" style="display: none;">

    <div class="alert alert-warning m-0" role="alert">
        This does not work right now.
    </div>

    <div class="d-flex flex-wrap align-items-center border-bottom px-4 py-3">
        <p class="fs-5 m-0">Custom API Route</p>

        <input type="text" class="form-control ms-auto" style="width: 300px;" disabled>
    </div>

</div>

@section("head.pages")

    <script>

        function updateAccountSetting(type, value) {
            fetch(`{{ $_ENV["APP_URL"] }}/api/account/${type}`, {
                method: "PUT",
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    "value": value
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            })
        }

        async function dropdownHandler(elem, setting, state) {

            $(elem).parent().parent().children().children().removeClass("active");
            $(elem).parent().parent().parent().find("button").first().text($(elem).text());
            $(elem).addClass("active");

            if (setting === "theme" && state === "dark") {
                $("body").attr("data-bs-theme", "dark");
                localStorage.setItem("bstheme", "dark");
            } else if (setting === "theme" && state === "light") {
                $("body").attr("data-bs-theme", "light");
                localStorage.setItem("bstheme", "light");
            } else if (setting === "visible_to_public" || setting === "save_episode_progress" || setting === "public_reviews") {
                updateAccountSetting(setting, state);
            }

        }



    </script>

@endsection
