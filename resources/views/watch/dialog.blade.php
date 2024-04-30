<div class="w-popups">

    <div class="w-popup" popup-id="error">

        <div class="w-popup-header">
            <h4>Error Encountered</h4>
        </div>

        <div class="w-popup-body">
            <p class="m-0">Something went wrong while fetching the episode. </p>
            <p class="m-0">Reload the page, choose a different server, use Gogoviewer or try again later.</p>
        </div>

        <div class="w-popup-buttonbox">
            <button class="btn btn-secondary" onclick="wpopups.hide()">Close</button>
            <button class="btn btn-primary" onclick="window.location.reload()">Reload</button>
        </div>

    </div>

    <div class="w-popup w-popup-fullscreen" popup-id="gogoanimeselector">

        <div class="w-popup-header">
            <h4>Choose the same anime</h4>
        </div>

        <div class="w-popup-body d-flex flex-column gap-2">
            <input type="text" placeholder="Search..." onkeydown="gogoSearchEvent()" onkeyup="gogoSearchEvent()">
            <div class="d-grid gap-2 d-none" id="grid" style="grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));"></div>
            <div class="d-flex justify-content-center" id="spinner">
                <div class="w-spinner w-spinner-size-2"></div>
            </div>
        </div>

        <div class="w-popup-buttonbox">
            <button class="btn btn-secondary" onclick="wpopups.hide()">Close</button>
        </div>

    </div>

    <div class="w-popup" popup-id="download">

        <div class="w-popup-header">
            <h4>Download Episode</h4>
        </div>

        <div class="w-popup-body">
            <div class="d-flex justify-content-center d-none" id="spinner"><div class="spinner"></div></div>
            <div id="resolutions" class="d-flex justify-content-center flex-wrap gap-2 d-none"></div>
            <div id="progressbar" class="d-none">
                <div class="d-flex justify-content-between" id="data"><p id="left"></p><p id="right"></p></div>
                <div class="w-progressbar"></div>
            </div>
        </div>

        <div class="w-popup-buttonbox">
            <button class="btn btn-secondary" onclick="wpopups.hide()">Cancel</button>
        </div>

    </div>

</div>