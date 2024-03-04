@extends("layout.root")

@section("body")

    <div class="d-flex flex-column align-items-center">

        <form class="px-2 py-4" style="width: min(400px, 100%)" method="post" action="{{ $_ENV["APP_URL"] }}/login">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @if ($errors->has('password'))
                    @foreach ($errors->get('password') as $err)
                        <p class="text-danger m-0">{{ $err }}</p>
                    @endforeach
                @endif
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="checkbox" name="stayloggedin">
                <label class="form-check-label" for="checkbox">
                  Stay logged in
                </label>
            </div>              
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <p class="text-body-secondary">Don't have an account? <a class="link-offset-2 link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="{{ $_ENV["APP_URL"] }}/account/register">Request account</a></p>
        </form>        

    </div>

@endsection