@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center" style="background-color: #dbb959;">
                    <h3 class="mt-2 mb-4 text-white">My Profile</h3>
                    <div class="user-avatar mx-auto mb-3">
                        <div style="width: 100px; height: 100px; background-color: #f5f5f5; border-radius: 50%; margin: 0 auto; display: flex; justify-content: center; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                            <i class="fa fa-user" style="font-size: 50px; color: #666;"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('profile.history') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                            <div>
                                <i class="fa fa-history me-3"></i>
                                History
                            </div>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('profile.personal-details') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                            <div>
                                <i class="fa fa-user me-3"></i>
                                Personal Details
                            </div>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('profile.about') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                            <div>
                                <i class="fa fa-info-circle me-3"></i>
                                About
                            </div>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('profile.help') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
                            <div>
                                <i class="fa fa-question-circle me-3"></i>
                                Help
                            </div>
                            <i class="fa fa-chevron-right"></i>
                        </a>
                        <a href="#" onclick="confirmLogout(event)" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
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