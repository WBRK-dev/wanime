<div id="servers" class="bg-body-secondary p-2 rounded d-flex flex-column gap-2">
    <div id="sub" class="d-flex align-items-center gap-2">SUB: <div class="d-flex gap-2 flex-wrap"></div></div>
    <div id="dub" class="d-flex align-items-center gap-2">DUB: <div class="d-flex gap-2 flex-wrap"></div></div>
</div>


@section("head.servers")
    
    <script>

        function renderServers(servers) {

            $("#servers #sub div").html("");
            for (let i = 0; i < servers.sub.length; i++) {
                $("#servers #sub div").append(`<button class="btn ${(!dub && servers.sub[i].serverName === videoserver) ? "btn-success" : "btn-secondary"}" onclick="serverClick(this, '${servers.sub[i].serverName}', 'sub')">${servers.sub[i].serverName}</button>`);
            }

            $("#servers #dub div").html("");
            for (let i = 0; i < servers.dub.length; i++) {
                $("#servers #dub div").append(`<button class="btn ${(dub && servers.dub[i].serverName === videoserver) ? "btn-success" : "btn-secondary"}" onclick="serverClick(this, '${servers.dub[i].serverName}', 'dub')">${servers.dub[i].serverName}</button>`);
            }
        }

        function serverClick(elem, server, category) {
            $("#servers button").removeClass("btn-success");
            $("#servers button").addClass("btn-secondary");

            $(elem).addClass("btn-success");
            $(elem).removeClass("btn-secondary");

            dub = (category === "dub") ? true : false;
            localStorage.setItem("dubbedvideo", dub);

            videoserver = server;
            localStorage.setItem("videoserver", videoserver);

            loadServer(server, category);
        }

    </script>

@endsection