@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('profile') }}" class="me-3">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        <h4 class="mb-0">Personal Details</h4>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('profile.update-details') }}" enctype="multipart/form-data">
                        @csrf
                        
                        @if(isset($employee) && $employee)
                            <!-- Profile Picture Section -->
                            <div class="mb-4 text-center">
                                <div class="profile-picture-container mb-3">
                                    @if($employee->profile_picture)
                                        <img src="{{ asset($employee->profile_picture) }}" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div style="width: 150px; height: 150px; background-color: #f5f5f5; border-radius: 50%; margin: 0 auto; display: flex; justify-content: center; align-items: center;">
                                            <i class="fa fa-user" style="font-size: 80px; color: #666;"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="mb-3">
                                    <label for="profile_picture" class="form-label">Change Profile Picture</label>
                                    <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" id="profile_picture" name="profile_picture">
                                    <div class="form-text">Accepted formats: JPG, PNG, GIF (max 2MB)</div>
                                    @error('profile_picture')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Employee-specific form fields -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="emp_first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control @error('emp_first_name') is-invalid @enderror" id="emp_first_name" name="emp_first_name" value="{{ old('emp_first_name', $employee->emp_first_name) }}">
                                    @error('emp_first_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="emp_surname" class="form-label">Surname</label>
                                    <input type="text" class="form-control @error('emp_surname') is-invalid @enderror" id="emp_surname" name="emp_surname" value="{{ old('emp_surname', $employee->emp_surname) }}">
                                    @error('emp_surname')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $employee->email) }}">
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror" id="contact_number" name="contact_number" value="{{ old('contact_number', $employee->contact_number) }}">
                                @error('contact_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', $employee->emergency_contact) }}">
                                @error('emergency_contact')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="street" class="form-label">Street</label>
                                <input type="text" class="form-control @error('street') is-invalid @enderror" id="street" name="street" value="{{ old('street', $employee->street) }}">
                                @error('street')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $employee->city) }}">
                                    @error('city')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="county" class="form-label">County</label>
                                    <input type="text" class="form-control @error('county') is-invalid @enderror" id="county" name="county" value="{{ old('county', $employee->county) }}">
                                    @error('county')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" class="form-control" id="role" value="{{ $employee->role }}" disabled>
                            </div>
                        @elseif(isset($client) && $client)
                            <!-- Client-specific form fields -->
                            <!-- Add client-specific form fields here -->
                        @endif
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('profile_picture').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            const profileImg = document.querySelector('.profile-picture-container img');
            if (profileImg) {
                profileImg.src = URL.createObjectURL(file);
            } else {
                const container = document.querySelector('.profile-picture-container');
                container.innerHTML = `<img src="${URL.createObjectURL(file)}" alt="Profile Picture" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">`;
            }
        }
    };
});
</script>
@endsection