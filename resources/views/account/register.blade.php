@extends("layout.root")

@section("body")
    
    <div class="d-flex flex-column align-items-center">

        <form class="px-2 py-4" style="width: min(400px, 100%)" method="post" action="{{ $_ENV["APP_URL"] }}/account/register">

            {{-- <div class="alert alert-warning mb-3" role="alert">
                This does not work right now.
            </div> --}}

            @csrf
            <div class="d-flex flex-column mb-3">
                <label for="username" class="mb-1">Username</label>
                <input type="text" id="username" name="name" required>
                @if ($errors->has('name'))
                    @foreach ($errors->get('name') as $err)
                        <p class="text-danger m-0">{{ $err }}</p>
                    @endforeach
                @endif
            </div>
            <div class="d-flex flex-column mb-3">
                <label for="email" class="mb-1">Email</label>
                <input type="email" id="email" name="email" required>
                @if ($errors->has('email'))
                    @foreach ($errors->get('email') as $err)
                        <p class="text-danger m-0">{{ $err }}</p>
                    @endforeach
                @endif
            </div>
            <div class="d-flex flex-column mb-3">
                <label for="password" class="mb-1">Password</label>
                <input type="password" id="password" name="password" required>
                @if ($errors->has('password'))
                    @foreach ($errors->get('password') as $err)
                        <p class="text-danger m-0">{{ $err }}</p>
                    @endforeach
                @endif
            </div>
            <div class="d-flex flex-column mb-3">
                <label for="password" class="mb-1">Password Again</label>
                <input type="password" id="password" name="passwordagain" required>
                @if ($errors->has('passwordagain'))
                    @foreach ($errors->get('passwordagain') as $err)
                        <p class="text-danger m-0">{{ $err }}</p>
                    @endforeach
                @endif
            </div>              
            <button type="submit" class="btn btn-primary w-100">Request Account</button>
            <p class="text-body-secondary">Already have an account? <a class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="{{ $_ENV["APP_URL"] }}/account">Login</a></p>
        </form>        

    </div>

@endsection