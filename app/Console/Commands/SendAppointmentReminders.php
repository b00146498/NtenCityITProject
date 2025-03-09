<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Models\Client;
use App\Notifications\AppointmentNotification;
use Carbon\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';
    protected $description = 'Send reminders for upcoming appointments';

    public function handle()
    {
        // Get tomorrow's date
        $tomorrow = Carbon::tomorrow()->toDateString();
        
        // Find all confirmed appointments for tomorrow
        $appointments = Appointment::where('booking_date', $tomorrow)
            ->where('status', 'confirmed')
            ->get();
            
        $this->info("Found {$appointments->count()} appointments for tomorrow.");
        
        foreach ($appointments as $appointment) {
            $client = Client::find($appointment->client_id);
            $client->notify(new AppointmentNotification($appointment, 'reminder'));
            $this->info("Sent reminder for appointment #{$appointment->id} to client #{$client->id}");
        }
        
        return Command::SUCCESS;
    }
}