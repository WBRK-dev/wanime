@extends("layout.root")

@section("body")
    
    <div class="d-flex flex-column align-items-center py-4">
        <h1>{{ $code }}</h1>
        <p>{{ $message }}</p>
    </div>

@endsection