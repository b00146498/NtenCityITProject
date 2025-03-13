@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fa fa-bell mr-2"></i>Notifications</h1>
        <div>
            <div class="btn-group shadow-sm">
                <a href="{{ route('notifications.index') }}" class="btn {{ !request()->has('filter') ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fa fa-list mr-1"></i> All
                </a>
                <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" class="btn {{ request()->get('filter') == 'unread' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fa fa-envelope mr-1"></i> Unread
                </a>
            </div>
            
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline ml-2">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-secondary">
                    <i class="fa fa-check-double mr-1"></i> Mark All as Read
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            @if(count($notifications) > 0)
                <div class="list-group list-group-flush">
                    @foreach($notifications as $notification)
                        <div class="list-group-item" style="background-color: #FFF8E1; border-radius: 8px; margin: 10px;">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <i class="fa fa-bell mt-1"></i>
                                </div>
                                
                                <div class="flex-grow-1">
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($notification->created_at)->format('jS F, Y') }}
                                    </div>
                                    
                                    @php
                                        $data = json_decode($notification->data);
                                    @endphp
                                    
                                    <div>
                                        @if(isset($data->message))
                                            {{ $data->message }}
                                        @elseif(isset($data->doctor_name))
                                            {{ $data->doctor_name }}
                                        @elseif(isset($data->type) && $data->type == 'payment')
                                            Appointment Paid Successfully
                                        @elseif(isset($data->type) && $data->type == 'account_updated')
                                            Account Details Updated
                                        @elseif(isset($data->type) && $data->type == 'account_created')
                                            Account Created
                                        @else
                                            Notification
                                        @endif
                                    </div>
                                </div>
                                
                                @if(!$notification->read_at)
                                    <div class="ml-2">
                                        <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background-color: #000;"></span>
                                    </div>
                                @endif
                            </div>
                            
                            @if(isset($data->appointment_id))
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary view-appointment" data-appointment-id="{{ $data->appointment_id }}">
                                        <i class="fa fa-eye mr-1"></i> View Appointment
                                    </button>
                                    
                                    @if(!$notification->read_at)
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                <i class="fa fa-check mr-1"></i> Mark as Read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="position-relative d-inline-block mb-3">
                        <i class="fa fa-bell fa-3x text-muted"></i>
                        <div class="position-absolute" style="top: 0; right: 0; width: 100%; height: 100%;">
                            <div style="width: 40px; height: 2px; background-color: #6c757d; transform: rotate(45deg); margin-top: 20px;"></div>
                        </div>
                    </div>
                    <p class="lead">No notifications found.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Appointment Details Modal -->
<div class="modal fade" id="appointmentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="appointmentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentDetailsModalLabel">Appointment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="appointmentDetails">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p>Loading appointment details...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .list-group-item {
        transition: all 0.2s;
    }
    
    .list-group-item:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@push('js_scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all the view appointment buttons
    const viewButtons = document.querySelectorAll('.view-appointment');
    
    // Log to confirm our script is running
    console.log('Found ' + viewButtons.length + ' appointment buttons');
    
    // Add click event listener to each button
    viewButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get the appointment ID from the data attribute
            const appointmentId = this.getAttribute('data-appointment-id');
            console.log('Viewing appointment ID: ' + appointmentId);
            
            // Create modal if it doesn't exist
            let modalElement = document.getElementById('appointmentModal');
            if (!modalElement) {
                const modalHTML = `
                    <div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="appointmentModalBody">
                                    <div class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading appointment details...</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.body.insertAdjacentHTML('beforeend', modalHTML);
                modalElement = document.getElementById('appointmentModal');
            }
            
            // Get the modal body where we'll put the content
            const modalBody = document.getElementById('appointmentModalBody');
            
            // Show loading state
            modalBody.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading appointment details...</p>
                </div>
            `;
            
            // Initialize Bootstrap 5 modal
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
            
            // Fetch appointment details
            fetch('/api/appointments/' + appointmentId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Format the date and time
                    const date = new Date(data.booking_date).toLocaleDateString('en-US', {
                        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
                    });
                    
                    // Format times
                    const startTime = formatTime(data.start_time);
                    const endTime = formatTime(data.end_time);
                    
                    // Update modal content
                    modalBody.innerHTML = `
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Appointment #${data.id}</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Date:</strong> ${date}</p>
                                        <p><strong>Time:</strong> ${startTime} - ${endTime}</p>
                                        <p><strong>Status:</strong> <span class="badge bg-${getStatusBadgeColor(data.status)}">${capitalizeFirstLetter(data.status)}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Client ID:</strong> ${data.client_id}</p>
                                        <p><strong>Employee ID:</strong> ${data.employee_id}</p>
                                        <p><strong>Practice ID:</strong> ${data.practice_id}</p>
                                    </div>
                                </div>
                                ${data.notes ? `<hr><h6>Notes:</h6><p>${data.notes}</p>` : ''}
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error fetching appointment details:', error);
                    modalBody.innerHTML = `
                        <div class="alert alert-danger">
                            <p>Error loading appointment details: ${error.message}</p>
                        </div>
                    `;
                });
        });
    });
    
    // Helper functions
    function formatTime(timeString) {
        if (!timeString) return 'Unknown';
        
        const timeParts = timeString.split(':');
        let hours = parseInt(timeParts[0]);
        const minutes = timeParts[1];
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // Convert 0 to 12
        return `${hours}:${minutes} ${ampm}`;
    }
    
    function capitalizeFirstLetter(string) {
        if (!string) return '';
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    
    function getStatusBadgeColor(status) {
        if (!status) return 'secondary'; // Default gray
        
        switch(status.toLowerCase()) {
            case 'confirmed': return 'success'; // Green
            case 'pending': return 'warning';   // Yellow
            case 'checked-in': return 'info';   // Blue
            case 'completed': return 'secondary'; // Gray
            case 'canceled': return 'danger';   // Red
            default: return 'secondary';        // Gray
        }
    }
});
</script>
@endpush