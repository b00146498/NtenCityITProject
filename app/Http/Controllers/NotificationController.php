<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Repositories\NotificationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationController extends AppBaseController
{
    /** @var NotificationRepository $notificationRepository*/
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Notification.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // Get the authenticated user
        $user = Auth::user();
        
        if (!$user) {
            Flash::error('You need to be logged in to view notifications');
            return redirect(route('login'));
        }
        
        // Get user notifications
        if ($request->has('filter') && $request->filter == 'unread') {
            $userNotifications = $user->unreadNotifications()->get();
        } else {
            $userNotifications = $user->notifications()->get();
        }
        
        // Try to get client notifications if the user has a client record
        try {
            // CHANGED HERE: from 'userid' to 'user_id'
            $client = \App\Models\Client::where('user_id', $user->id)->first();
            
            if ($client && method_exists($client, 'notifications')) {
                Log::info('Found client record for user', ['user_id' => $user->id, 'client_id' => $client->id]);
                
                // Get client notifications
                $clientNotifications = $request->has('filter') && $request->filter == 'unread'
                    ? $client->unreadNotifications()->get()
                    : $client->notifications()->get();
                
                // Merge user and client notifications
                $allNotifications = $userNotifications->merge($clientNotifications);
                
                // Sort by created_at (newest first)
                $allNotifications = $allNotifications->sortByDesc('created_at');
                
                // Paginate manually
                $page = $request->get('page', 1);
                $perPage = 10;
                $total = $allNotifications->count();
                $items = $allNotifications->forPage($page, $perPage);
                
                // Create custom paginator
                $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                    $items,
                    $total,
                    $perPage,
                    $page,
                    ['path' => $request->url(), 'query' => $request->query()]
                );
                
                Log::info('Combined notifications', [
                    'user_notifications' => $userNotifications->count(),
                    'client_notifications' => $clientNotifications->count(),
                    'total' => $total
                ]);
                
                return view('notifications.index')
                    ->with('notifications', $paginator);
            }
        } catch (\Exception $e) {
            Log::error('Error retrieving client notifications', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        // If no client record, or error occurred, just use user notifications
        if ($request->has('filter') && $request->filter == 'unread') {
            $notifications = $user->unreadNotifications()->paginate(10);
        } else {
            $notifications = $user->notifications()->paginate(10);
        }

        return view('notifications.index')
            ->with('notifications', $notifications);
    }

    /**
     * Show the form for creating a new Notification.
     *
     * @return Response
     */
    public function create()
    {
        return view('notifications.create');
    }

    /**
     * Store a newly created Notification in storage.
     *
     * @param CreateNotificationRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationRequest $request)
    {
        $input = $request->all();

        $notification = $this->notificationRepository->create($input);

        Flash::success('Notification saved successfully.');

        return redirect(route('notifications.index'));
    }

    /**
     * Display the specified Notification.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        return view('notifications.show')->with('notification', $notification);
    }

    /**
     * Show the form for editing the specified Notification.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        return view('notifications.edit')->with('notification', $notification);
    }

    /**
     * Update the specified Notification in storage.
     *
     * @param int $id
     * @param UpdateNotificationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationRequest $request)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        $notification = $this->notificationRepository->update($request->all(), $id);

        Flash::success('Notification updated successfully.');

        return redirect(route('notifications.index'));
    }

    /**
     * Remove the specified Notification from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $notification = $this->notificationRepository->find($id);

        if (empty($notification)) {
            Flash::error('Notification not found');

            return redirect(route('notifications.index'));
        }

        $this->notificationRepository->delete($id);

        Flash::success('Notification deleted successfully.');

        return redirect(route('notifications.index'));
    }
    
    /**
     * Mark a notification as read
     *
     * @param string $id
     * @return Response
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->where('id', $id)->first();
        
        if (empty($notification)) {
            // Check if it's a client notification
            try {
                // CHANGED HERE: from 'userid' to 'user_id'
                $client = \App\Models\Client::where('user_id', $user->id)->first();
                if ($client && method_exists($client, 'notifications')) {
                    $notification = $client->notifications()->where('id', $id)->first();
                }
            } catch (\Exception $e) {
                Log::error('Error finding client notification to mark as read', [
                    'error' => $e->getMessage()
                ]);
            }
            
            if (empty($notification)) {
                Flash::error('Notification not found');
                return redirect(route('notifications.index'));
            }
        }
        
        $notification->markAsRead();
        
        Flash::success('Notification marked as read.');
        return redirect()->back();
    }
    
    /**
     * Mark all notifications as read
     *
     * @return Response
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();
        
        // Also mark client notifications as read if applicable
        try {
            $client = \App\Models\Client::where('email', $user->email)->first();
            if ($client && method_exists($client, 'unreadNotifications')) {
                $client->unreadNotifications->markAsRead();
            }
        } catch (\Exception $e) {
            Log::error('Error marking client notifications as read', [
                'error' => $e->getMessage()
            ]);
        }
        
        Flash::success('All notifications marked as read.');
        return redirect()->back();
    }
    
    /**
     * Create a test notification (for debugging)
     *
     * @return Response
     */
    public function createTestNotification()
    {
        $user = Auth::user();
        
        if (!$user) {
            Flash::error('You need to be logged in to create a test notification');
            return redirect(route('login'));
        }
        
        // Get a recent appointment if available
        $appointment = \App\Models\Appointment::latest()->first();
        
        if (!$appointment) {
            // Create dummy appointment data if no appointment exists
            $appointment = new \stdClass();
            $appointment->id = 1;
            $appointment->booking_date = now()->format('Y-m-d');
            $appointment->start_time = '14:00:00';
            $appointment->end_time = '15:00:00';
            $appointment->status = 'confirmed';
            $appointment->notes = 'Test appointment';
        }
        
        // Send the test notification
        $user->notify(new \App\Notifications\AppointmentNotification($appointment, 'confirmation'));
        
        Flash::success('Test notification created successfully.');
        
        return redirect(route('notifications.index'));
    }
    
    /**
     * Get color for notification type
     */
    public function getNotificationTypeColor($type)
    {
        return match (strtolower($type)) {
            'confirmation' => 'success',
            'update'       => 'info',
            'reminder'     => 'warning',
            'cancellation' => 'danger',
            default        => 'primary',
        };
    }

    /**
     * Get badge color for appointment status
     */
    public function getStatusBadgeColor($status)
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
