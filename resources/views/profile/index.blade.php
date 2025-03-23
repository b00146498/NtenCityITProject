@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="card border-0 rounded-0">
                <div class="card-header text-center border-0" style="background-color: #dbb959; padding: 2rem 0;">
                    <h3 class="text-white mb-4">My Profile</h3>
                    <div class="user-avatar mx-auto mb-3">
                        @if(isset($employee) && $employee && $employee->profile_picture)
                            <div style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto; overflow: hidden;">
                                <img src="{{ asset($employee->profile_picture) }}" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @elseif(isset($client) && $client && isset($client->profile_picture))
                            <div style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto; overflow: hidden;">
                                <img src="{{ asset($client->profile_picture) }}" alt="Profile Picture" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @else
                            <div style="width: 100px; height: 100px; background-color: #f5f5f5; border-radius: 50%; margin: 0 auto; display: flex; justify-content: center; align-items: center;">
                                <i class="fa fa-user" style="font-size: 50px; color: #666;"></i>
                            </div>
                        @endif
                    </div>
                    @if(isset($employee) && $employee)
                        <h5 class="text-white">{{ $employee->emp_first_name }} {{ $employee->emp_surname }}</h5>
                        <p class="text-white mb-0">{{ $employee->role }}</p>
                    @elseif(isset($client) && $client)
                        <h5 class="text-white">{{ $client->first_name }} {{ $client->surname }}</h5>
                        <p class="text-white mb-0">Client</p>
                    @endif
                </div>

                <div class="card-body p-0">
                    <div class="list-group rounded-0">
                        <a href="{{ route('profile.personal-details') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3 border-start-0 border-end-0">
                            <div>
                                <i class="fa fa-user me-3"></i>
                                Personal Details
                            </div>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('profile.about') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3 border-start-0 border-end-0">
                            <div>
                                <i class="fa fa-info-circle me-3"></i>
                                About
                            </div>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('profile.help') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3 border-start-0 border-end-0">
                            <div>
                                <i class="fa fa-question-circle me-3"></i>
                                Help
                            </div>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="#" onclick="confirmLogout(event)" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3 border-start-0 border-end-0">
                            <div>
                                <i class="fa fa-sign-out-alt me-3"></i>
                                Log out
                            </div>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<script>
function confirmLogout(event) {
    event.preventDefault();
    if (confirm('Are you sure you want to log out?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>
@endsection