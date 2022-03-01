<nav class="navbar navbar-expand-lg @guest navbar-light light-dark @endguest @auth navbar-dark bg-dark @endauth">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('guest.index') }}">{{ config('app.name', 'Laravel') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                @guest
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                @else
                    {{-- se vogliamo usare un link e js per fare un submit, la rotta logout e' una post --}}
                    {{-- <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a> --}}

                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit" class="btn btn-light" value="Logout">
                    </form>
                @endguest
            </div>
        </div>



    </div>
</nav>
