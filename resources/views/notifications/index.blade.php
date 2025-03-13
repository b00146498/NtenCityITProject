

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

    @include('flash::message')

    <div class="card shadow">
        <div class="card-body p-0">
            @if(count($notifications) > 0)
                <div class="list-group list-group-flush">
                    @foreach($notifications as $notification)
                        <div class="list-group-item notification-item">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <i class="fa fa-bell mt-1"></i>
                                </div>
                                
                                <div class="flex-grow-1">
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($notification->created_at)->format('jS F, Y') }}
                                    </div>
                                    
                                    <div class="notification-text">
                                        @if(isset($notification->data['type']) && $notification->data['type'] == 'appointment')
                                            @if(isset($notification->data['doctor_name']))
                                                {{ $notification->data['doctor_name'] }}
                                            @else
                                                Appointment Notification
                                            @endif
                                        @elseif(isset($notification->data['type']) && $notification->data['type'] == 'payment')
                                            Appointment Paid Successfully
                                        @elseif(isset($notification->data['type']) && $notification->data['type'] == 'account_updated')
                                            Account Details Updated
                                        @elseif(isset($notification->data['type']) && $notification->data['type'] == 'account_created')
                                            Account Created
                                        @elseif(isset($notification->data['message']))
                                            {{ $notification->data['message'] }}
                                        @else
                                            Notification
                                        @endif
                                    </div>
                                </div>
                                
                                @if(!$notification->read_at)
                                    <div class="ml-2">
                                        <span class="unread-indicator"></span>
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
@endsection

@push('styles')
<style>
    .notification-item {
        background-color: #FFF8E1;
        border-radius: 8px;
        margin: 10px;
        transition: all 0.2s;
        border: none;
    }
    
    .notification-item:hover {
        transform: translateY(-2px);
    }
    
    .notification-text {
        font-size: 1rem;
        font-weight: normal;
    }
    
    .unread-indicator {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #000;
        margin-top: 5px;
    }
</style>
@endpush