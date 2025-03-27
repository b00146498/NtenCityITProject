@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-white py-3">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('profile') }}" class="me-3 text-white">
                            <i class="fa fa-arrow-left fa-lg"></i>
                        </a>
                        <h4 class="mb-0">Personal Details</h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('profile.update-details') }}" enctype="multipart/form-data">
                        @csrf
                        
                        @if(isset($employee) && $employee)
                            <!-- Profile Picture Section -->
                            <div class="mb-4 text-center">
                                <div class="profile-picture-container position-relative mb-3 mx-auto" style="width: 180px; height: 180px;">
                                    @if($employee->profile_picture)
                                        <img src="{{ asset($employee->profile_picture) }}" 
                                             alt="Profile Picture" 
                                             class="rounded-circle w-100 h-100 object-fit-cover shadow-sm">
                                    @else
                                        <div class="w-100 h-100 bg-light rounded-circle d-flex justify-content-center align-items-center">
                                            <i class="fa fa-user text-muted" style="font-size: 80px;"></i>
                                        </div>
                                    @endif
                                    <label for="profile_picture" class="position-absolute bottom-0 end-0 mb-2 me-2 btn btn-sm btn-light rounded-circle shadow-sm" style="width: 40px; height: 40px;">
                                        <i class="fa fa-camera"></i>
                                        <input type="file" class="d-none @error('profile_picture') is-invalid @enderror" id="profile_picture" name="profile_picture" accept="image/*">
                                    </label>
                                </div>
                                
                                @error('profile_picture')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="emp_first_name" class="form-label">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control @error('emp_first_name') is-invalid @enderror" 
                                               id="emp_first_name" 
                                               name="emp_first_name" 
                                               value="{{ old('emp_first_name', $employee->emp_first_name) }}"
                                               placeholder="Enter first name">
                                        @error('emp_first_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="emp_surname" class="form-label">Surname</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control @error('emp_surname') is-invalid @enderror" 
                                               id="emp_surname" 
                                               name="emp_surname" 
                                               value="{{ old('emp_surname', $employee->emp_surname) }}"
                                               placeholder="Enter surname">
                                        @error('emp_surname')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $employee->email) }}"
                                           placeholder="Enter email address">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="contact_number" class="form-label">Contact Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        <input type="text" class="form-control @error('contact_number') is-invalid @enderror" 
                                               id="contact_number" 
                                               name="contact_number" 
                                               value="{{ old('contact_number', $employee->contact_number) }}"
                                               placeholder="Enter contact number">
                                        @error('contact_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-users"></i></span>
                                        <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" 
                                               id="emergency_contact" 
                                               name="emergency_contact" 
                                               value="{{ old('emergency_contact', $employee->emergency_contact) }}"
                                               placeholder="Enter emergency contact">
                                        @error('emergency_contact')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="street" class="form-label">Street</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                               id="street" 
                                               name="street" 
                                               value="{{ old('street', $employee->street) }}"
                                               placeholder="Enter street address">
                                        @error('street')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="city" class="form-label">City</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-city"></i></span>
                                        <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                               id="city" 
                                               name="city" 
                                               value="{{ old('city', $employee->city) }}"
                                               placeholder="City">
                                        @error('city')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="county" class="form-label">County</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-globe"></i></span>
                                        <input type="text" class="form-control @error('county') is-invalid @enderror" 
                                               id="county" 
                                               name="county" 
                                               value="{{ old('county', $employee->county) }}"
                                               placeholder="Enter county">
                                        @error('county')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="role" class="form-label">Current Role</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-briefcase"></i></span>
                                        <input type="text" class="form-control" 
                                               id="role" 
                                               value="{{ $employee->role }}" 
                                               disabled>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save me-2"></i>Update Details
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profilePictureInput = document.getElementById('profile_picture');
    const profilePictureContainer = document.querySelector('.profile-picture-container');

    profilePictureInput.addEventListener('change', function(evt) {
        const [file] = this.files;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = profilePictureContainer.querySelector('img');
                const defaultIcon = profilePictureContainer.querySelector('.fa-user');

                if (img) {
                    img.src = e.target.result;
                } else if (defaultIcon) {
                    defaultIcon.parentElement.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Profile Picture" 
                             class="rounded-circle w-100 h-100 object-fit-cover shadow-sm">
                    `;
                }
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
@endsection