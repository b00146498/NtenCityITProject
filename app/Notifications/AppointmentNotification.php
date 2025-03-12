<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentNotification extends Notification
{
    use Queueable;

    protected $appointment;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($appointment, $type = 'confirmation')
    {
        $this->appointment = $appointment;
        $this->type = $type; // confirmation, reminder, update, cancellation
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject($this->getSubject())
            ->greeting('Hello ' . ($notifiable->first_name ?? 'there') . '!')
            ->line($this->getMainLine());

        // Format date and time nicely
        try {
            $date = date('l, F j, Y', strtotime($this->appointment->booking_date));
            $startTime = date('g:i A', strtotime($this->appointment->start_time));
            $endTime = date('g:i A', strtotime($this->appointment->end_time));

            // Add appointment details
            $message->line('Appointment Details:')
                    ->line('Date: ' . $date)
                    ->line('Time: ' . $startTime . ' - ' . $endTime)
                    ->line('Status: ' . ucfirst($this->appointment->status));

            // Add notes if available
            if (!empty($this->appointment->notes)) {
                $message->line('Notes: ' . $this->appointment->notes);
            }

            // Add action button
            $message->action('View Appointment Details', url('/appointments/' . $this->appointment->id));
        } catch (\Exception $e) {
            \Log::error('Error formatting appointment notification: ' . $e->getMessage());
            $message->line('Please check your appointment details in the system.');
        }

        return $message;
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        try {
            // Format date and time nicely
            $date = date('l, F j, Y', strtotime($this->appointment->booking_date));
            $startTime = date('g:i A', strtotime($this->appointment->start_time));
            $endTime = date('g:i A', strtotime($this->appointment->end_time));

            return [
                'type' => $this->type,
                'appointment_id' => $this->appointment->id,
                'booking_date' => $this->appointment->booking_date,
                'formatted_date' => $date,
                'start_time' => $this->appointment->start_time,
                'end_time' => $this->appointment->end_time,
                'formatted_time' => $startTime . ' - ' . $endTime,
                'status' => $this->appointment->status,
                'notes' => $this->appointment->notes ?? '',
                'message' => $this->getMainLine()
            ];
        } catch (\Exception $e) {
            \Log::error('Error creating database notification: ' . $e->getMessage());
            
            return [
                'type' => $this->type,
                'message' => 'You have a new ' . $this->type . ' notification.',
                'error' => 'There was an error processing the full notification details.'
            ];
        }
    }

    /**
     * Get the subject line for email notifications.
     */
    private function getSubject()
    {
        switch ($this->type) {
            case 'confirmation':
                return 'Appointment Confirmed';
            case 'reminder':
                return 'Appointment Reminder';
            case 'update':
                return 'Appointment Updated';
            case 'cancellation':
                return 'Appointment Cancelled';
            default:
                return 'Appointment Notification';
        }
    }

    /**
     * Get the main notification message.
     */
    private function getMainLine()
    {
        try {
            // Format date for message
            $date = date('l, F j', strtotime($this->appointment->booking_date));
            $time = date('g:i A', strtotime($this->appointment->start_time));

            switch ($this->type) {
                case 'confirmation':
                    return "Your appointment on {$date} at {$time} has been confirmed!";
                case 'reminder':
                    return "This is a reminder about your upcoming appointment on {$date} at {$time}.";
                case 'update':
                    return "Your appointment on {$date} at {$time} has been updated.";
                case 'cancellation':
                    return "Your appointment on {$date} at {$time} has been cancelled.";
                default:
                    return "You have an appointment on {$date} at {$time}.";
            }
        } catch (\Exception $e) {
            \Log::error('Error generating notification message: ' . $e->getMessage());
            return "You have a new " . $this->type . " notification.";
        }
    }
}