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
                            <!-- Simplified card design to match wireframe -->
                            <div class="list-group-item bg-light border-0 mb-2" style="background-color: #FFF8E1 !important; border-radius: 8px; margin: 10px;">
                                <div class="d-flex">
                                    <!-- Bell icon on left -->
                                    <div class="mr-3">
                                        <i class="fa fa-bell mt-1"></i>
                                    </div>
                                    
                                    <!-- Notification content -->
                                    <div class="flex-grow-1">
                                        <!-- Date and Doctor name -->
                                        @if(isset($notification->data['booking_date']))
                                            <div class="text-muted small">
                                                {{ \Carbon\Carbon::parse($notification->data['booking_date'])->format('jS F, Y') }}
                                            </div>
                                        @else
                                            <div class="text-muted small">
                                                {{ \Carbon\Carbon::parse($notification->created_at)->format('jS F, Y') }}
                                            </div>
                                        @endif

                                        <!-- Doctor name or notification type -->
                                        <h5 class="mb-0 font-weight-normal">
                                            @if(isset($notification->data['doctor_name']))
                                                Dr. {{ $notification->data['doctor_name'] }}
                                            @elseif(isset($notification->data['type']) && $notification->data['type'] == 'payment')
                                                Appointment Paid Successfully
                                            @elseif(isset($notification->data['type']) && $notification->data['type'] == 'account_updated')
                                                Account Details Updated
                                            @elseif(isset($notification->data['type']) && $notification->data['type'] == 'account_created')
                                                Account Created
                                            @else
                                                {{ ucfirst($notification->data['type'] ?? 'Notification') }}
                                            @endif
                                        </h5>
                                    </div>
                                    
                                    <!-- Unread indicator dot -->
                                    @if(!$notification->read_at)
                                        <div class="ml-2">
                                            <span class="badge badge-dark rounded-circle">&nbsp;</span>
                                        </div>
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
</div>
@endsection

@push('scripts')
<script>
    // Optional JavaScript enhancements can go here
</script>
@endpush

@push('styles')
<style>
    /* Add custom styles to match wireframe */
    .list-group-item {
        transition: all 0.2s;
    }
    
    .list-group-item:hover {
        transform: translateY(-2px);
    }
    
    .badge.rounded-circle {
        display: inline-block;
        width: 8px;
        height: 8px;
        padding: 0;
    }
</style>
@endpush


