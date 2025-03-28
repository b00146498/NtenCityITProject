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

<!-- Hidden form for CSRF token -->
<form id="csrf-form" style="display: none;">
    @csrf
</form>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const avatarContainer = document.querySelector('.user-avatar');
    const profilePictureInput = document.getElementById('profile-picture-input');
    let profilePicturePreview = document.getElementById('profile-picture-preview');
    const uploadOverlay = document.getElementById('upload-overlay');
    const csrfToken = document.querySelector('input[name="_token"]').value;

    // Click to trigger file input
    if (avatarContainer) {
        avatarContainer.addEventListener('click', () => {
            profilePictureInput.click();
        });
    }

    // Show/hide upload overlay
    if (avatarContainer && uploadOverlay) {
        avatarContainer.addEventListener('mouseenter', () => {
            uploadOverlay.style.display = 'flex';
        });

        avatarContainer.addEventListener('mouseleave', () => {
            uploadOverlay.style.display = 'none';
        });
    }

    // Handle file selection
    if (profilePictureInput) {
        profilePictureInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            console.log('File selected:', file.name, file.type, file.size);
            
            // Validate file type
            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'];
            if (!validImageTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, GIF, WebP)');
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(e) {
                try {
                    // Preview the image
                    if (profilePicturePreview && profilePicturePreview.tagName && profilePicturePreview.tagName.toLowerCase() === 'div') {
                        // Create a new image element
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.id = 'profile-picture-preview';
                        img.style.width = '100%';
                        img.style.height = '100%';
                        img.style.borderRadius = '50%';
                        img.style.objectFit = 'cover';
                        
                        // Replace the div with the new image
                        if (profilePicturePreview.parentNode) {
                            profilePicturePreview.parentNode.replaceChild(img, profilePicturePreview);
                            profilePicturePreview = img; // Update the reference
                        } else {
                            console.error('Cannot replace profile picture: parent node is null');
                        }
                    } else if (profilePicturePreview) {
                        // Just update the src of the existing image
                        profilePicturePreview.src = e.target.result;
                    } else {
                        console.error('Profile picture preview element not found');
                    }
                } catch (error) {
                    console.error('Error updating preview image:', error);
                }
                
                // Prepare FormData for upload
                const formData = new FormData();
                formData.append('profile_picture', file);
                formData.append('_token', csrfToken);
                
                console.log('Sending request to:', '{{ route("profile.upload-picture") }}');
                
                // Send AJAX request to upload
                fetch('{{ route("profile.upload-picture") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Server returned ' + response.status + ' ' + response.statusText);
                    }
                    return response.text().then(text => {
                        try {
                            return text ? JSON.parse(text) : {};
                        } catch (e) {
                            console.error('Error parsing response as JSON:', e);
                            console.log('Raw response:', text);
                            throw new Error('Invalid JSON response from server');
                        }
                    });
                })
                .then(data => {
                    console.log('Upload response:', data);
                    if (data.success) {
                        console.log('Profile picture updated successfully');
                        console.log('Path returned:', data.path);
                        
                        // Update the image source with the server-side path
                        const img = document.getElementById('profile-picture-preview');
                        if (img) {
                            img.src = data.path;
                            console.log('Updated image source to:', img.src);
                            
                            // Save the path to localStorage
                            localStorage.setItem('profilePicturePath', data.path);
                        }
                    } else {
                        console.error('Upload failed:', data.errors || data.message || 'Unknown error');
                        alert('Failed to upload profile picture: ' + (data.errors || data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Error uploading profile picture. Please try again. ' + error.message);
                });
            };
            
            reader.onerror = function(e) {
                console.error('FileReader error:', e);
                alert('Error reading the image file. Please try again.');
            };

            reader.readAsDataURL(file);
        });
    }
    
    // Check if we have a saved path in localStorage
    const savedPath = localStorage.getItem('profilePicturePath');
    if (savedPath && profilePicturePreview && profilePicturePreview.tagName && profilePicturePreview.tagName.toLowerCase() === 'img') {
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