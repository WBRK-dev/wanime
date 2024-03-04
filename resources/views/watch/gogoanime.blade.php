<div class="modal fade" id="gogoanimeselector" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Alternative anime selector</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column gap-2">
                    <input type="text" class="form-control" onkeydown="gogoSearchEvent()" onkeyup="gogoSearchEvent()">
                    <div id="gogoanimegrid" class="d-grid gap-2" style="grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));"></div>
                    <div class="d-flex justify-content-center d-none" id="loader"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section("head.gogoanime")
    <script data-label="Script required for loading the alternative anime from the provider gogoanime.">

        let gogoModal;
        let gogoSearchTimeout;
        let aniwatchToGogoIds = JSON.parse(localStorage.getItem("aniwatchtogogo") || '{}');

        let gogoAnime = {};

        async function initGogo() {
            $("#gogoanimeselectbutton").removeClass("d-none");
            $("#servers").addClass("d-none");
            $("#video #wanimelogo #backup").removeClass("d-none");
            if (aniwatchToGogoIds["{{$anime["anime"]["info"]["id"]}}"]) {
                gogoProvider = true;
                $("#gogoanimeselectbutton").text("Loading anime");
                await fetchGogoAnime(aniwatchToGogoIds["{{$anime["anime"]["info"]["id"]}}"]);
                loadGogoEp(episodeIndex);
            } else showGogoDialog();
        }

        function showGogoDialog() {
            $("#gogoanimeselector input").val("{{$anime["anime"]["info"]["name"]}}");
            gogoSearch();
            if (!gogoModal) gogoModal = new bootstrap.Modal('#gogoanimeselector');
            gogoModal.show();
        }

        async function gogoSearch() {
            $("#gogoanimeselector #gogoanimegrid").addClass("d-none");
            $("#gogoanimeselector #gogoanimegrid").html("");
            $("#gogoanimeselector #loader").removeClass("d-none");

            let search = $("#gogoanimeselector input").val();
            let response = await (await fetch(`{{config("app.gogo_api_url")}}/gogo/search?q=${search}`)).json();
            if (response.error) return;

            for (let i = 0; i < response.results.length; i++) {
                $("#gogoanimeselector #gogoanimegrid").append(`<button class="card text-decoration-none w-100 mt-2 p-0" onclick="chooseGogoAnime('${response.results[i].id}')"><img src="${response.results[i].image}" class="card-img-top w-100" alt="Image" style="aspect-ratio: 1/1.36; object-fit: cover;"><div class="card-body p-2"><h5 class="card-title fs-6 mb-0 text-start">${response.results[i].title}</h5></div></button>`);
            }

            $("#gogoanimeselector #loader").addClass("d-none");
            $("#gogoanimeselector #gogoanimegrid").removeClass("d-none");
        }

        function gogoSearchEvent() {
            $("#gogoanimeselector #gogoanimegrid").addClass("d-none");
            $("#gogoanimeselector #gogoanimegrid").html("");
            $("#gogoanimeselector #loader").removeClass("d-none");

            clearTimeout(gogoSearchTimeout);
            gogoSearchTimeout = setTimeout(gogoSearch, 3000);
        }

        async function chooseGogoAnime(id) {
            aniwatchToGogoIds["{{$anime["anime"]["info"]["id"]}}"] = id;
            localStorage.setItem("aniwatchtogogo", JSON.stringify(aniwatchToGogoIds));

            gogoProvider = true;
            gogoModal.hide();

            await fetchGogoAnime(id);
            loadGogoEp(episodeIndex);
        }

        async function fetchGogoAnime(id) {
            $("#video #loadercircle").removeClass("d-none");
            $("#video #errorcircle").addClass("d-none");
            $("#video #wanimelogo").addClass("d-none");

            let response = await (await fetch(`{{config("app.gogo_api_url")}}/gogo/info?id=${id}`)).json();
            if (response.error) return;

            $("#gogoanimeselectbutton").text(response.title);

            gogoAnime = response;
        }

        async function loadGogoEp(i) {
            episodeIndex = i;
            episodeSkipTimes = [];
            subtitles = [];
            $("#video #settings #subtitles").html("");
            $("#video #settings #quality").html("");
            $("#video #track").html("");
            $('#video video track[kind="subtitles"]').remove();
            $("#video #loadercircle").removeClass("d-none");
            $("#video #errorcircle").addClass("d-none");
            $("#video #wanimelogo").addClass("d-none");

            fetch(`{{ $_ENV["APP_URL"] }}/api/episode/{{ $anime["anime"]["info"]["id"] }}`, {
                method: "PUT",
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    "episode": i
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            });

            let episodeId = gogoAnime.episodes[i].id;
            let response = await (await fetch(`{{config("app.gogo_api_url")}}/gogo/source?id=${episodeId}`)).json();
            if (response.error) {
                $("#video #loadercircle").addClass("d-none");
                $("#video #errorcircle").removeClass("d-none");
                return;
            }

            let source = response.sources.find(obj => obj.quality === "default") ?? response.sources[0];

            loadVideo(source.url);
        }

    </script>
@endsection