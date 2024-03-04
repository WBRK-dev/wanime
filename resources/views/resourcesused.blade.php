@extends("layout.root")

@section("body")
    
    <div class="d-flex justify-content-center p-2"><div class="d-flex flex-column gap-2 w-100" style="max-width: 1000px;">
    
        <a class="d-flex gap-2 border rounded p-2 text-decoration-none text-body" href="https://laravel.com/" target="_blank">
            <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel Logo" style="max-height: 100px; width: 30%; object-fit: contain; flex-shrink: 0;">
            <div>
                <h4 class="">Laravel Framework</h4>
                <p class="m-0">Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.</p>
            </div>
        </a>

        <a class="d-flex gap-2 border rounded p-2 text-decoration-none text-body" href="https://getbootstrap.com/" target="_blank">
            <img src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo-shadow.png" alt="Bootstrap Logo" style="max-height: 100px; width: 30%; object-fit: contain; flex-shrink: 0;">
            <div>
                <h4 class="">Bootstrap</h4>
                <p class="m-0">Powerful, extensible, and feature-packed frontend toolkit. Build and customize with Sass, utilize prebuilt grid system and components, and bring projects to life with powerful JavaScript plugins.</p>
            </div>
        </a>

        <a class="d-flex gap-2 border rounded p-2 text-decoration-none text-body" href="https://github.com/ghoshritesh12/aniwatch-api" target="_blank">
            <img src="https://cdn-icons-png.flaticon.com/512/25/25231.png" alt="Github Logo" style="max-height: 100px; width: 30%; object-fit: contain; flex-shrink: 0;">
            <div>
                <h4 class="">Aniwatch API by ghoshritesh12</h4>
                <p class="m-0">Node.js API for obtaining anime information from aniwatch.to (formerly zoro.to) written in TypeScript, made with Cheerio & Axios.</p>
            </div>
        </a>
    
    </div></div>

@endsection