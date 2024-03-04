@extends("layout.root")

@section("body")
    <div class="d-flex flex-column mt-2 align-items-center justify-content-center">
        <h1>500</h1>
        <h3>Server error</h3>
        <a href="{{ $_ENV["APP_URL"] }}/" class="mb-4">Home</a>
    </div>
@endsection