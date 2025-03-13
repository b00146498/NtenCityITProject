

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

    <div class="card mb-4">
        <div class="card-body">
            <h5>Debug Information:</h5>
            <p>Current User ID: {{ auth()->id() }}</p>
            <p>User Notifications Count: {{ auth()->user()->notifications->count() }}</p>
            
            @php
                $client = \App\Models\Client::where('userid', auth()->id())->first();
            @endphp
            
            @if($client)
                <p>Associated Client ID: {{ $client->id }}</p>
                <p>Client Model Class: {{ get_class($client) }}</p>
                <p>Client has Notifiable trait: {{ method_exists($client, 'notify') ? 'Yes' : 'No' }}</p>
                @if(method_exists($client, 'notifications'))
                    <p>Client Notifications Count: {{ $client->notifications->count() }}</p>
                @else
                    <p>Client doesn't have notifications method</p>
                @endif
            @else
                <p>No Client record found for this user</p>
            @endif
            
            <h5>Raw Database Check:</h5>
            @php
                $rawNotifications = DB::table('notifications')
                    ->where('notifiable_type', 'App\\Models\\Client')
                    ->where('notifiable_id', $client ? $client->id : 0)
                    ->get();
            @endphp
            <p>Raw Client Notifications: {{ $rawNotifications->count() }}</p>
            
            @if($rawNotifications->count() > 0)
                <pre>{{ json_encode($rawNotifications->first(), JSON_PRETTY_PRINT) }}</pre>
            @endif
        </div>
    </div>

    {{-- Debug information --}}
    <div class="card mb-4 d-none">
        <div class="card-body">
            <h5>Debug Info:</h5>
            <ul>
                <li>User ID: {{ auth()->id() }}</li>
                <li>User notifications: {{ auth()->user()->notifications()->count() }}</li>
                <li>Unread notifications: {{ auth()->user()->unreadNotifications()->count() }}</li>
            </ul>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            @php
                // Combine notifications from both user model and client model if user has a client record
                $allNotifications = auth()->user()->notifications;
                
                // Try to find client associated with user
                $client = null;
                try {
                    $client = \App\Models\Client::where('userid', auth()->id())->first();
                } catch (\Exception $e) {
                    // Client table might not exist or other error
                }
                
                if ($client && method_exists($client, 'notifications')) {
                    $clientNotifications = $client->notifications;
                    $allNotifications = $allNotifications->merge($clientNotifications);
                }
                
                // Sort by created_at
                $allNotifications = $allNotifications->sortByDesc('created_at');
                
                // Filter for unread if requested
                if (request()->has('filter') && request()->get('filter') == 'unread') {
                    $allNotifications = $allNotifications->whereNull('read_at');
                }
            @endphp
            
            @if(count($allNotifications) > 0)
                <div class="list-group list-group-flush">
                    @foreach($allNotifications as $notification)
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
                                        @elseif(isset($notification->data['type']) && $notification->data['type'] == 'confirmation')
                                            @if(isset($notification->data['doctor_name']))
                                                {{ $notification->data['doctor_name'] }}
                                            @else
                                                Appointment Confirmed
                                            @endif
                                        @elseif(isset($notification->data['message']))
                                            {{ $notification->data['message'] }}
                                        @else
                                            Notification
                                        @endif
                                    </div>
                                    
                                    @if(isset($notification->data['notes']))
                                        <p class="text-muted mt-1 mb-0 small">{{ $notification->data['notes'] }}</p>
                                    @endif
                                </div>
                                
                                @if(!$notification->read_at)
                                    <div class="ml-2">
                                        <span class="unread-indicator"></span>
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