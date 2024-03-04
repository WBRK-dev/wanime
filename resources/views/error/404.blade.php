@extends("layout.root")

@section("body")
    <div class="d-flex flex-column mt-2 align-items-center justify-content-center">
        <h1>404</h1>
        <h3>Not found</h3>
        <a href="{{ $_ENV["APP_URL"] }}/" class="mb-2">Home</a>
    </div>
@endsection