{{-- <div class="modal fade" id="errormodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Playback error <span></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="m-0">Something went wrong while fetching the episode. Reload the page, choose a different server, use Gogoviewer or try again later.</p>
            </div>
            <div class="modal-footer">
                <span class="badge bg-danger me-auto">Code: <span id="errorcode"></span></span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="initGogo()" data-bs-dismiss="modal">Gogoviewer</button>
                <button type="button" class="btn btn-primary" onclick="window.location.reload()">Reload</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="servererrormodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Server error <span></span></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="m-0">Something went wrong while fetching the episode. </p>
                <p class="mb-2">Reload the page, choose a different server, use Gogoviewer or try again later.</p>
                <p class="m-0">If this error keeps recurring, please send the code below.</p>
                <span class="badge bg-danger" id="errorpastecode"></span>
            </div>
            <div class="modal-footer">
                <span class="badge bg-danger me-auto">Code: <span id="errorcode"></span></span>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a type="button" class="btn btn-secondary" href="/gogoviewer/?search={{$anime["anime"]["info"]["name"]}}" target="_blank">Gogoviewer</a>
                <button type="button" class="btn btn-primary" onclick="window.location.reload()">Reload</button>
            </div>
        </div>
    </div>
</div> --}}

