<li class="nav-item">
    <a href="{{ route('employees.index') }}"
       class="nav-link {{ Request::is('employees*') ? 'active' : '' }}">
        <p>Employees</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('clients.index') }}"
       class="nav-link {{ Request::is('clients*') ? 'active' : '' }}">
        <p>Clients</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('practices.index') }}"
       class="nav-link {{ Request::is('practices*') ? 'active' : '' }}">
        <p>Practices</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('appointments.index') }}"
       class="nav-link {{ Request::is('appointments*') ? 'active' : '' }}">
        <p>Appointments</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('customers.index') }}"
       class="nav-link {{ Request::is('customers*') ? 'active' : '' }}">
        <p>Customers</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('notifications.index') }}"
       class="nav-link {{ Request::is('notifications*') ? 'active' : '' }}">
        <p>Notifications</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('standardexercises.index') }}"
       class="nav-link {{ Request::is('standardexercises*') ? 'active' : '' }}">
        <p>Standardexercises</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('tpelogs.index') }}"
       class="nav-link {{ Request::is('tpelogs*') ? 'active' : '' }}">
        <p>Tpelogs</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('personalisedtrainingplans.index') }}"
       class="nav-link {{ Request::is('personalisedtrainingplans*') ? 'active' : '' }}">
        <p>Personalisedtrainingplans</p>
    </a>
</li>


