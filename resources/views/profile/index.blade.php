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
                            <img src="{{ asset($employee->profile_picture) }}" 
                                 id="profile-picture-preview"
                                 alt="Profile Picture" 
                                 style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                        @elseif(isset($client) && $client && $client->profile_picture)
                            <img src="{{ asset($client->profile_picture) }}" 
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

<!-- You can keep or remove the test forms as needed -->
<div style="margin: 20px; padding: 20px; border: 1px solid #ccc;">
    <h4>Test Upload Form</h4>
    <form id="test-upload-form" enctype="multipart/form-data">
        @csrf
        <input type="file" name="profile_picture" id="test-profile-picture">
        <button type="submit">Upload (Regular Form)</button>
    </form>
    
    <hr>
    
    <h4>Test Upload with Fetch</h4>
    <input type="file" id="test-fetch-input">
    <button id="test-fetch-button">Upload with Fetch</button>
    
    <div id="upload-result" style="margin-top: 10px; padding: 10px; background-color: #f5f5f5;"></div>
</div>

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

    // Handle file selection - UPDATED WITH WORKING CODE
    if (profilePictureInput) {
        profilePictureInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            console.log('File selected:', file.name, file.type, file.size);
            
            // Show the image preview immediately
            const reader = new FileReader();
            reader.onload = function(e) {
                if (profilePicturePreview.tagName.toLowerCase() === 'div') {
                    // If it's the default icon, replace with an img
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.id = 'profile-picture-preview';
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.borderRadius = '50%';
                    img.style.objectFit = 'cover';
                    
                    if (profilePicturePreview.parentNode) {
                        profilePicturePreview.parentNode.replaceChild(img, profilePicturePreview);
                        profilePicturePreview = img;
                    }
                } else {
                    profilePicturePreview.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
            
            // Use the working FormData pattern from the test
            const formData = new FormData();
            formData.append('profile_picture', file);
            formData.append('_token', csrfToken);
            
            fetch('{{ route("profile.upload-picture") }}', {
                method: 'POST',
                body: formData,
                // Don't include any Content-Type header - browser sets it with boundary
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Upload response:', data);
                if (data.success) {
                    console.log('Profile picture updated successfully');
                    
                    // Update the image with the returned path from server
                    if (profilePicturePreview) {
                        profilePicturePreview.src = data.path;
                    }
                } else {
                    console.error('Upload failed:', data.message || 'Unknown error');
                    alert('Failed to upload profile picture: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                alert('Error uploading profile picture. Please try again.');
            });
        });
    }

    // Regular form submission test
    document.getElementById('test-upload-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        
        fetch('{{ route("profile.upload-picture") }}', {
            method: 'POST',
            body: new FormData(form)
        })
        .then(response => {
            document.getElementById('upload-result').innerHTML = 'Response status: ' + response.status;
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                document.getElementById('upload-result').innerHTML += '<br>Response: ' + JSON.stringify(data);
            } catch (e) {
                document.getElementById('upload-result').innerHTML += '<br>Raw response: ' + text;
            }
        })
        .catch(error => {
            document.getElementById('upload-result').innerHTML += '<br>Error: ' + error.message;
        });
    });
    
    // Fetch API test
    document.getElementById('test-fetch-button').addEventListener('click', function() {
        const file = document.getElementById('test-fetch-input').files[0];
        if (!file) {
            alert('Please select a file first');
            return;
        }
        
        const formData = new FormData();
        formData.append('profile_picture', file);
        formData.append('_token', csrfToken);
        
        fetch('{{ route("profile.upload-picture") }}', {
            method: 'POST',
            body: formData
            // No headers - let browser set the Content-Type with boundary
        })
        .then(response => {
            document.getElementById('upload-result').innerHTML = 'Fetch Response status: ' + response.status;
            return response.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                document.getElementById('upload-result').innerHTML += '<br>Fetch Response: ' + JSON.stringify(data);
            } catch (e) {
                document.getElementById('upload-result').innerHTML += '<br>Fetch Raw response: ' + text;
            }
        })
        .catch(error => {
            document.getElementById('upload-result').innerHTML += '<br>Fetch Error: ' + error.message;
        });
    });
});

function confirmLogout(event) {
    event.preventDefault();
    if (confirm('Are you sure you want to log out?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>
@endpush