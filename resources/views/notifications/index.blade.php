@extends('layouts.app')

@section('content')
<div class="container">
    <section class="content-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-0"><i class="fa fa-bell mr-2"></i>Notifications</h1>
            <div class="btn-group shadow-sm">
                <a href="{{ route('notifications.index') }}" class="btn {{ !request()->has('filter') ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fa fa-list mr-1"></i> All
                </a>
                <a href="{{ route('notifications.index', ['filter' => 'unread']) }}" class="btn {{ request()->get('filter') == 'unread' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fa fa-envelope mr-1"></i> Unread
                </a>
                
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline ml-2">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-secondary">
                            <i class="fa fa-check-double mr-1"></i> Mark All as Read
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <div class="content">
        @include('flash::message')

        <div class="card shadow">
            <div class="card-body p-0">
                @if(count($notifications) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($notifications as $notification)
                            <div class="list-group-item {{ $notification->read_at ? 'bg-white' : 'bg-light border-left border-primary border-4' }}">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="mb-0">
                                        @if(!$notification->read_at)
                                            <span class="badge badge-pill badge-primary mr-2">New</span>
                                        @endif
                                        <span class="text-{{ getNotificationTypeColor($notification->data['type'] ?? 'appointment') }}">
                                            {{ ucfirst($notification->data['type'] ?? 'Appointment') }} Notification
                                        </span>
                                    </h5>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                </div>
                                
                                <p class="mb-3 lead">{{ $notification->data['message'] ?? 'Appointment notification' }}</p>
                                
                                <div class="card bg-light mb-3">
                                    <div class="card-body py-3">
                                        <div class="row">
                                            @if(isset($notification->data['booking_date']))
                                                <div class="col-md-4 mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-calendar-alt text-primary mr-2"></i>
                                                        <div>
                                                            <small class="text-muted d-block">Date</small>
                                                            <strong>
                                                                {{ isset($notification->data['formatted_date']) ? 
                                                                    $notification->data['formatted_date'] : 
                                                                    \Carbon\Carbon::parse($notification->data['booking_date'])->format('l, F j, Y') }}
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if(isset($notification->data['start_time']) && isset($notification->data['end_time']))
                                                <div class="col-md-4 mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-clock text-primary mr-2"></i>
                                                        <div>
                                                            <small class="text-muted d-block">Time</small>
                                                            <strong>
                                                                {{ isset($notification->data['formatted_time']) ? 
                                                                    $notification->data['formatted_time'] : 
                                                                    \Carbon\Carbon::parse($notification->data['start_time'])->format('g:i A') . ' - ' . 
                                                                    \Carbon\Carbon::parse($notification->data['end_time'])->format('g:i A') }}
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if(isset($notification->data['status']))
                                                <div class="col-md-4 mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-info-circle text-primary mr-2"></i>
                                                        <div>
                                                            <small class="text-muted d-block">Status</small>
                                                            <span class="badge badge-{{ getStatusBadgeColor($notification->data['status']) }}">
                                                                {{ ucfirst($notification->data['status']) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if(isset($notification->data['notes']) && !empty($notification->data['notes']))
                                            <div class="mt-3">
                                                <div class="d-flex align-items-start">
                                                    <i class="fa fa-comment-alt text-primary mt-1 mr-2"></i>
                                                    <div>
                                                        <small class="text-muted d-block">Notes</small>
                                                        <p class="mb-0">{{ $notification->data['notes'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    @if(isset($notification->data['appointment_id']))
                                        <a href="{{ route('appointments.show', $notification->data['appointment_id']) }}" 
                                           class="btn btn-primary">
                                            <i class="fa fa-eye mr-1"></i> View Appointment
                                        </a>
                                    @else
                                        <div></div>
                                    @endif
                                    
                                    @if(!$notification->read_at)
                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-outline-secondary">
                                                <i class="fa fa-check mr-1"></i> Mark as Read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center p-4">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fa fa-bell-slash fa-3x text-muted mb-3"></i>
                        <p class="lead">No notifications found.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Optional JavaScript enhancements can go here
</script>
@endpush