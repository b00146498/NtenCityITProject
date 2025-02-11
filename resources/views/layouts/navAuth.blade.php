<ul class="nav navbar-nav pull-right">
    @if(Auth::guest())
        <li>
            <a href="{{ route('register') }}">Register</a>
            <span class="glyphicon glyphicon-pencil"></span>
        </li>
        <li>
            <a href="{{ route('login') }}">Login</a>
            <span class="glyphicon glyphicon-log-in"></span>
        </li>
    @else
        <li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout <span class="glyphicon glyphicon-log-out"></span>
            </a>
        </li>

    @endif
</ul>

