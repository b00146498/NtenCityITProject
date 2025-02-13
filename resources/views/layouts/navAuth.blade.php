<ul class="nav flex-column">
    @if(Auth::guest())
        <li class="nav-item">
            <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                <i class="fas fa-user-plus"></i> Register
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </li>
    @else
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    @endif
</ul>


