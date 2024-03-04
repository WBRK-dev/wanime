@extends("layout.root")

@section("body")
    
    <div id="maingrid" class="d-grid gap-2 p-2 h-100" style="grid-template-columns: 300px 1fr;">
        <div style="height: max-content;">
            <div class="btn-group-vertical w-100" role="group" aria-label="Vertical radio toggle button group">
                <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio1" autocomplete="off" checked>
                <label class="btn btn-outline-secondary" for="vbtn-radio1" onclick="open_page('general')">General</label>
                <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio2" autocomplete="off">
                <label class="btn btn-outline-secondary" for="vbtn-radio2" onclick="open_page('privacy')">Privacy</label>
                <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio3" autocomplete="off">
                <label class="btn btn-outline-secondary" for="vbtn-radio3" onclick="open_page('account')">Account</label>
                <input type="radio" class="btn-check" name="vbtn-radio" id="vbtn-radio4" autocomplete="off">
                <label class="btn btn-outline-secondary" for="vbtn-radio4" onclick="open_page('advanced')">Advanced</label>
            </div>
        </div>
        
        <div id="settings" class="border rounded h-100 overflow-auto" style="min-height: 400px;">
            @include("account.settings.settingpages")
        </div>
    </div>

@endsection

@section("head")
    
    <script>

        function open_page(id) {
            $("#settings > *").hide();
            $(`#settings > #${id}`).show();
        }

    </script>
    <style>

        @media only screen and (max-width: 900px) {

            #maingrid {
                grid-template-columns: 1fr !important;
                grid-template-rows: auto 1fr !important;
            }

        }

    </style>

    @yield("head.pages")

@endsection