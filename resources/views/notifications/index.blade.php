

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
                        <div class="list-group-item" style="background-color: #FFF8E1; border-radius: 8px; margin: 10px;">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <i class="fa fa-bell mt-1"></i>
                                </div>
                                
                                <div class="flex-grow-1">
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($notification->created_at)->format('jS F, Y') }}
                                    </div>
                                    
                                    <h5 class="mb-0">
                                        @if(isset($notification->data['type']) && $notification->data['type'] == 'appointment')
                                            @if(isset($notification->data['doctor_name']))
                                                {{ $notification->data['doctor_name'] }}
                                            @else
                                                Appointment Notification
                                            @endif
                                        @elseif(isset($notification->data['message']))
                                            {{ $notification->data['message'] }}
                                        @else
                                            Notification
                                        @endif
                                    </h5>
                                    
                                    @if(isset($notification->data['notes']))
                                        <p class="mb-0 mt-1 text-muted">{{ $notification->data['notes'] }}</p>
                                    @endif
                                </div>
                                
                                @if(!$notification->read_at)
                                    <div class="ml-2">
                                        <span class="badge badge-dark rounded-circle">&nbsp;</span>
                                    </div>
                                @endif
                            </div>
                            
                            @if(isset($notification->data['appointment_id']))
                                <div class="mt-2">
                                    <a href="{{ route('appointments.show', $notification->data['appointment_id']) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-eye mr-1"></i> View Appointment
                                    </a>
                                    
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