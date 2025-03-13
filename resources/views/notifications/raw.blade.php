@extends('layouts.app')

@section('content')
<div class="container">
    <h1><i class="fa fa-bell mr-2"></i>Notifications</h1>
    
    <div class="card shadow">
        <div class="card-body">
            @if(count($notifications) > 0)
                <div class="list-group">
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
                                        @if(isset($data->doctor_name))
                                            {{ $data->doctor_name }}
                                        @elseif(isset($data->message))
                                            {{ $data->message }}
                                        @elseif(isset($data->type) && $data->type == 'confirmation')
                                            Appointment Confirmed
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