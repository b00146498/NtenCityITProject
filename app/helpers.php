<?php

// Notification type color helper
if (!function_exists('getNotificationTypeColor')) {
    function getNotificationTypeColor($type)
    {
        return match (strtolower($type)) {
            'confirmation' => 'success',
            'update'       => 'info',
            'reminder'     => 'warning', 
            'cancellation' => 'danger',
            default        => 'primary',
        };
    }
}

// Status badge color helper
if (!function_exists('getStatusBadgeColor')) {
    function getStatusBadgeColor($status)
    {
        return match (strtolower($status)) {
            'confirmed'  => 'success',
            'pending'    => 'warning',
            'checked-in' => 'info',
            'completed'  => 'secondary',
            'canceled'   => 'danger',
            default      => 'primary',
        };
    }
}