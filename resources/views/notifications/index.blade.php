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

@push('scripts')
<script>
$(document).ready(function() {
    // Handle appointment view button click
    $('.view-appointment').click(function() {
        var appointmentId = $(this).data('appointment-id');
        
        // Clear previous content
        $('#appointmentDetails').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div><p>Loading appointment details...</p></div>');
        
        // Show modal
        $('#appointmentDetailsModal').modal('show');
        
        // Fetch appointment details
        $.ajax({
            url: '/api/appointments/' + appointmentId,
            type: 'GET',
            success: function(response) {
                // Format appointment details
                var html = '<div class="card">';
                html += '<div class="card-body">';
                
                // Basic details
                html += '<h5 class="card-title">Appointment #' + response.id + '</h5>';
                html += '<div class="row">';
                
                // Date and time
                html += '<div class="col-md-6">';
                html += '<p><strong>Date:</strong> ' + formatDate(response.booking_date) + '</p>';
                html += '<p><strong>Time:</strong> ' + formatTime(response.start_time) + ' - ' + formatTime(response.end_time) + '</p>';
                html += '<p><strong>Status:</strong> <span class="badge badge-' + getStatusBadgeColor(response.status) + '">' + capitalizeFirstLetter(response.status) + '</span></p>';
                html += '</div>';
                
                // Client and employee info
                html += '<div class="col-md-6">';
                html += '<p><strong>Client ID:</strong> ' + response.client_id + '</p>';
                html += '<p><strong>Employee ID:</strong> ' + response.employee_id + '</p>';
                html += '<p><strong>Practice ID:</strong> ' + response.practice_id + '</p>';
                html += '</div>';
                html += '</div>';
                
                // Notes
                if (response.notes) {
                    html += '<hr><h6>Notes:</h6>';
                    html += '<p>' + response.notes + '</p>';
                }
                
                html += '</div>'; // card-body
                html += '</div>'; // card
                
                // Update modal content
                $('#appointmentDetails').html(html);
            },
            error: function(xhr) {
                $('#appointmentDetails').html('<div class="alert alert-danger">Error loading appointment details. Please try again.</div>');
            }
        });
    });
    
    // Helper functions
    function formatDate(dateString) {
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString(undefined, options);
    }
    
    function formatTime(timeString) {
        var timeParts = timeString.split(':');
        var hours = parseInt(timeParts[0]);
        var minutes = timeParts[1];
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // Convert 0 to 12
        return hours + ':' + minutes + ' ' + ampm;
    }
    
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    
    function getStatusBadgeColor(status) {
        switch(status.toLowerCase()) {
            case 'confirmed': return 'success';
            case 'pending': return 'warning';
            case 'checked-in': return 'info';
            case 'completed': return 'secondary';
            case 'canceled': return 'danger';
            default: return 'primary';
        }
    }
});
</script>
@endpush