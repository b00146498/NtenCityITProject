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
        
        // Filter notifications based on request
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
            Flash::error('Notification not found');
            return redirect(route('notifications.index'));
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
        
        Flash::success('All notifications marked as read.');
        return redirect()->back();
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