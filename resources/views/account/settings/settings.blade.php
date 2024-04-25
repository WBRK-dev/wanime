@extends("layout.root")

@section("body")

    <div class="d-grid h-100 p-2 gap-2" style="grid-template-columns: 300px 1fr; min-height: 400px;">

        <div class="setting-list">

            <button class="setting-item active" onclick="openPage('general', this)"><i class="fi fi-sr-settings"></i><p>General</p></button>
            <button class="setting-item" onclick="openPage('privacy', this)"><i class="fi fi-sr-incognito"></i><p>Privacy</p></button>
            <button class="setting-item" onclick="openPage('account', this)"><i class="fi fi-sr-user"></i><p>Account</p></button>
            <button class="setting-item" onclick="openPage('advanced', this)"><i class="fi fi-sr-square-code"></i><p>Advanced</p></button>

        </div>

        <div class="setting-pages">

            @include("account.settings.settingspages")

        </div>


    </div>

@endsection

@section("head")
    
    <script>

        function openPage(id, btn) {
            $(".setting-pages > div").addClass("d-none");
            $(`.setting-pages > [setting-page-id="${id}"]`).removeClass("d-none");

            if (btn) {
                $(btn).parent().children().removeClass("active");
                $(btn).addClass("active");
            }
        }

    </script>
    <style>

        .setting-list {
            display: flex;
            flex-direction: column;
        }

        .setting-list .setting-item {
            display: flex; gap: .5rem;
            align-items: center;

            background: transparent;
            border: none;
            border-radius: .25rem;

            padding: .5rem .5rem;

            font-size: 16px;
            color: var(--bs-secondary-color);

            cursor: pointer;
            transition: background-color 250ms, color 250ms;
        }

        .setting-list .setting-item:hover, .setting-list .setting-item.active {color: var(--bs-body-color); background-color: var(--tertiary-hover-subtle-bg);}

    </style>

@endsection