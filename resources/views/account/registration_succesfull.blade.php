@extends("layout.root")

@section("body")
    
    <div class="d-flex flex-column align-items-center p-4">

        <div class="w-100 rounded bg-body-secondary rounded p-4 d-flex flex-column align-items-center" style="max-width: 600px;">
        
            <div class="bg-success rounded-circle p-3"><i class="fi fi-sr-check fi-32"></i></div>

            <h4 class="mt-4 mb-2 text-center">Your account has been requested</h4>
            <p class="text-center">More information will come in your email.</p>
            <a href="{{ $_ENV["APP_URL"] }}/" class="btn btn-primary">To Home</a>

        </div>       

    </div>

@endsection