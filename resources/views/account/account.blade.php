@extends("layout.root")

@section("body")

    <div class="d-flex flex-column align-items-center py-4 px-2">

        <div class="d-grid bg-primary rounded-circle fs-2 mb-4" style="aspect-ratio: 1; place-items: center; width: 100px;">{{ $user_initials }}</div>
        <h3 class="mb-4">{{ Auth::user()->name }}</h3>

        {{-- <div class="d-flex gap-4">
            <div>
                <p class="m-0">Completed:</p>
                <p class="m-0">Planning:</p>
                <p class="m-0">Watching:</p>
                <p class="m-0">Paused:</p>
                <p class="m-0">Dropped:</p>
                <p class="m-0">Trophies:</p>
            </div>

            <div>
                <p class="m-0">89</p>
                <p class="m-0">23</p>
                <p class="m-0">1</p>
                <p class="m-0">0</p>
                <p class="m-0">3</p>
                <p class="m-0">4</p>
            </div>

        </div> --}}

    </div>

    <script>

        function test() {
            fetch("{{ $_ENV["APP_URL"] }}/api/episode/naruto-677", {
                method: "PUT",
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    "episode": 4
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            });
        }

        function watchList(status) {
            fetch(`{{ $_ENV["APP_URL"] }}/api/watchlist/naruto-677`, {
                method: "PUT",
                body: JSON.stringify({
                    "_token": "{{ csrf_token() }}",
                    "status": status,
                    "anime": {
                        "title": "Naruto",
                        "image": "https://img.flawlessfiles.com/_r/300x400/100/5d/b4/5db400c33f7494bc8ae96f9e634958d0/5db400c33f7494bc8ae96f9e634958d0.jpg"
                    }
                }),
                headers: {
                    "Content-Type": "application/json"
                }
            });
        }

    </script>

@endsection