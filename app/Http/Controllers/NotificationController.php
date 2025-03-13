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
use Illuminate\Support\Facades\DB;

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
        
        try {
            // Get user notifications from database
            $userQuery = DB::table('notifications')
                ->where('notifiable_type', 'App\\Models\\User')
                ->where('notifiable_id', $user->id);
                
            // Get client notifications from database - using case-insensitive query
            // App\Models\client (lowercase) in DB, but code uses App\Models\Client
            $clientQuery = DB::table('notifications')
                ->whereRaw('LOWER(notifiable_type) = ?', [strtolower('App\\Models\\client')]);
                
            // If we're filtering to unread only
            if ($request->has('filter') && $request->filter == 'unread') {
                $userQuery->whereNull('read_at');
                $clientQuery->whereNull('read_at');
            }
            
            // Get both sets of notifications
            $userNotifications = $userQuery->get();
            $clientNotifications = $clientQuery->get();
            
            // Convert to Laravel collection for easier manipulation
            $allNotifications = collect($userNotifications->all())
                ->merge($clientNotifications->all())
                ->sortByDesc('created_at');
                
            // Paginate the results manually
            $page = $request->get('page', 1);
            $perPage = 10;
            $items = $allNotifications->forPage($page, $perPage);
            
            // Create a length-aware paginator
            $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                $allNotifications->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            
            return view('notifications.index')
                ->with('notifications', $paginator);
                
        } catch (\Exception $e) {
            Log::error('Error getting notifications: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Fallback to just user notifications
            if ($request->has('filter') && $request->filter == 'unread') {
                $notifications = $user->unreadNotifications()->paginate(10);
            } else {
                $notifications = $user->notifications()->paginate(10);
            }
            
            return view('notifications.index')
                ->with('notifications', $notifications);
        }
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
        try {
            // Try to find and mark the notification regardless of type
            $notification = DB::table('notifications')
                ->where('id', $id)
                ->first();
                
            if (!$notification) {
                Flash::error('Notification not found');
                return redirect(route('notifications.index'));
            }
            
            // Mark as read by updating the read_at timestamp
            DB::table('notifications')
                ->where('id', $id)
                ->update(['read_at' => now()]);
                
            Flash::success('Notification marked as read.');
        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            Flash::error('Error marking notification as read.');
        }
        
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
        
        try {
            // Mark all user notifications as read
            $user->unreadNotifications->markAsRead();
            
            // Also mark any client notifications as read
            DB::table('notifications')
                ->whereRaw('LOWER(notifiable_type) = ?', [strtolower('App\\Models\\client')])
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
                
            Flash::success('All notifications marked as read.');
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read: ' . $e->getMessage());
            Flash::error('Error marking all notifications as read.');
        }
        
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