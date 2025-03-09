<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Appointment;
use App\Models\Client;
use App\Notifications\AppointmentNotification;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        
        // Send daily appointment reminders at 9:00 AM
        $schedule->call(function () {
            // Get tomorrow's date
            $tomorrow = Carbon::tomorrow()->toDateString();
            
            // Find all confirmed appointments for tomorrow
            $appointments = Appointment::where('booking_date', $tomorrow)
                ->where('status', 'confirmed')
                ->get();
                
            \Log::info("Sending reminders for {$appointments->count()} appointments scheduled for tomorrow ({$tomorrow})");
            
            foreach ($appointments as $appointment) {
                $client = Client::find($appointment->client_id);
                if ($client) {
                    // Send reminder notification
                    $client->notify(new AppointmentNotification($appointment, 'reminder'));
                    \Log::info("Sent reminder for appointment #{$appointment->id} to client #{$client->id}");
                }
            }
        })->dailyAt('09:00');
        
        // Clean up old notifications (keep last 30 days)
        $schedule->call(function () {
            $threshold = now()->subDays(30);
            $deleted = \DB::table('notifications')
                ->whereDate('created_at', '<', $threshold)
                ->delete();
            \Log::info("Deleted {$deleted} old notifications");
        })->weekly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}