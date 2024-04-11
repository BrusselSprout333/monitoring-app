<header>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a href="/"><img src="{{ asset('assets/images/gaming-chair.png') }}" width="50" alt="" style="margin-right: 10px"></a>
        <a class="navbar-brand" href="/">ComfortApp</a>

        <ul class="navbar-nav ml-auto" id="menu-items">
            <li class="nav-item">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <a class="nav-link" href="{{ route('profilePage') }}"><img class="nav-img" src="{{ asset('assets/images/user.png') }}" width="20" alt=""></a>
                @endif
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('monitorPage') }}"><img class="nav-img" src="{{ asset('assets/images/camera.png') }}" width="20" alt=""></a>
            </li>
            <li class="nav-item">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <a class="nav-link" href="{{ route('reports') }}"><img class="nav-img" src="{{ asset('assets/images/copy-alt.png') }}" width="20" alt=""></a>
                @endif
            </li>
            <li class="nav-item">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <a class="nav-link" href="{{ route('auth.logout') }}"><img class="nav-img" src="{{ asset('assets/images/sign-out-alt.png') }}" width="20" alt=""></a>
                @else
                    <a class="nav-link" href="{{ route('auth.login') }}"><img class="nav-img" src="{{ asset('assets/images/enter.png') }}" width="20" alt=""></a>
                @endif
            </li>
        </ul>
    </nav>
</header>
