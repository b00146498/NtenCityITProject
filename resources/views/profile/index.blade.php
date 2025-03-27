@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="card border-0 rounded-0">
                <div class="card-header text-center border-0" style="background-color: #dbb959; padding: 2rem 0;">
                    <h3 class="text-white mb-4">My Profile</h3>
                    
                    <div class="user-avatar mx-auto mb-3 position-relative" style="width: 100px; height: 100px; cursor: pointer;">
                        <input type="file" id="profile-picture-input" name="profile_picture" style="display: none;" accept="image/*">
                        
                        @if(isset($employee) && $employee && $employee->profile_picture)
                            <img src="{{ asset('storage/' . $employee->profile_picture) }}" 
                                 id="profile-picture-preview"
                                 alt="Profile Picture" 
                                 style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                        @elseif(isset($client) && $client && $client->profile_picture)
                            <img src="{{ asset('storage/' . $client->profile_picture) }}" 
                                 id="profile-picture-preview"
                                 alt="Profile Picture" 
                                 style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                        @else
                            <div id="profile-picture-preview" 
                                 style="width: 100%; height: 100%; background-color: #f5f5f5; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                <i class="fa fa-user" style="font-size: 50px; color: #666;"></i>
                            </div>
                        @endif
                        
                        <div class="position-absolute top-0 start-0 w-100 h-100" 
                             style="border-radius: 50%; background: rgba(0,0,0,0.3); display: none; justify-content: center; align-items: center;" 
                             id="upload-overlay">
                            <i class="fa fa-camera text-white" style="font-size: 24px;"></i>
                        </div>
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

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarContainer = document.querySelector('.user-avatar');
    const profilePictureInput = document.getElementById('profile-picture-input');
    const profilePicturePreview = document.getElementById('profile-picture-preview');
    const uploadOverlay = document.getElementById('upload-overlay');

    // Click to trigger file input
    avatarContainer.addEventListener('click', () => {
        profilePictureInput.click();
    });

    // Show/hide upload overlay
    avatarContainer.addEventListener('mouseenter', () => {
        uploadOverlay.style.display = 'flex';
    });

    avatarContainer.addEventListener('mouseleave', () => {
        uploadOverlay.style.display = 'none';
    });

    // Handle file selection
    profilePictureInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Preview the image
                if (profilePicturePreview.tagName.toLowerCase() === 'div') {
                    // If it's the default icon, replace with an img
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.id = 'profile-picture-preview';
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.borderRadius = '50%';
                    img.style.objectFit = 'cover';
                    profilePicturePreview.parentNode.replaceChild(img, profilePicturePreview);
                } else {
                    profilePicturePreview.src = e.target.result;
                }
                
                // Prepare FormData for upload
                const formData = new FormData();
                formData.append('profile_picture', file);
                formData.append('_token', '{{ csrf_token() }}');

                // Send AJAX request to upload
                fetch('{{ route("profile.upload-picture") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Upload response:', data);
                    if (data.success) {
                        console.log('Profile picture updated successfully');
                        console.log('Path returned:', data.path);
                        console.log('Debug info:', data.debug_info);
                        
                        // Update the image source with the server-side path
                        const img = document.getElementById('profile-picture-preview');
                        if (img) {
                            img.src = data.path;
                            console.log('Updated image source to:', img.src);
                            
                            // Save the path to localStorage as a backup
                            localStorage.setItem('profilePicturePath', data.path);
                        }
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                });
            };

            reader.readAsDataURL(file);
        }
    });
    
    // Check if we have a saved path in localStorage (as a backup)
    const savedPath = localStorage.getItem('profilePicturePath');
    if (savedPath && profilePicturePreview && profilePicturePreview.tagName.toLowerCase() === 'img') {
        console.log('Restoring profile picture from saved path:', savedPath);
        profilePicturePreview.src = savedPath;
    }
});

function confirmLogout(event) {
    event.preventDefault();
    if (confirm('Are you sure you want to log out?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>
@endpush