<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Repositories\AppointmentRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Flash;
use Response;
use Carbon\Carbon;
use App\Notifications\AppointmentNotification;


class AppointmentController extends AppBaseController
{
    private $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepo)
    {
        $this->appointmentRepository = $appointmentRepo;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $appointments = $this->appointmentRepository->all()->map(function ($appointment) {
                return [
                    'id'    => $appointment->id,
                    'title' => "Client #{$appointment->client_id} - {$appointment->status}",
                    'start' => "{$appointment->booking_date}T{$appointment->start_time}",
                    'end'   => "{$appointment->booking_date}T{$appointment->end_time}",
                    'color' => $this->getStatusColor($appointment->status),
                    'notes' => $appointment->notes,
                ];
            });

            return response()->json($appointments);
        }

        return view('appointments.index');
    }

    private function getStatusColor($status)
    {
        return match (strtolower($status)) {
            'confirmed'  => 'green',
            'pending'    => 'yellow',
            'checked-in' => 'blue',
            'completed'  => 'gray',
            'canceled'   => 'red',
            default      => 'black',
        };
    }

    public function store(Request $request)
    {
        Log::info('📌 Received Appointment Booking Request', $request->all());

        // Modified validation to handle time format with AM/PM
        $validator = Validator::make($request->all(), [
            'client_id'    => 'required',
            'employee_id'  => 'required',
            'practice_id'  => 'required',
            'booking_date' => 'required|date',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'status'       => 'nullable|string',
            'notes'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            Log::error('❌ Validation Failed', $validator->errors()->toArray());
            return response()->json(['error' => 'Invalid input', 'messages' => $validator->errors()], 400);
        }

        // Format the data for database insertion
        $data = $request->all();
        
        // Convert AM/PM times to 24-hour format if needed
        if (strpos($data['start_time'], 'AM') !== false || strpos($data['start_time'], 'PM') !== false) {
            $startDateTime = Carbon::parse($data['start_time']);
            $data['start_time'] = $startDateTime->format('H:i:s');
        }
        
        if (strpos($data['end_time'], 'AM') !== false || strpos($data['end_time'], 'PM') !== false) {
            $endDateTime = Carbon::parse($data['end_time']);
            $data['end_time'] = $endDateTime->format('H:i:s');
        }
        
        // Format has now been standardized to a format your database expects
        try {
            $appointment = $this->appointmentRepository->create($data);

            if (!$appointment) {
                Log::error('❌ Appointment Creation Failed');
                return response()->json(['error' => 'Failed to create appointment'], 500);
            }

            // Get client details for notifications
            $client = \App\Models\Client::find($appointment->client_id);
            
            // Send confirmation notification
            $this->sendAppointmentConfirmation($appointment, $client);
            
            // Send database notification
            $this->sendDatabaseNotification($appointment, $client, 'confirmation');

            Log::info('✅ Appointment Successfully Created', $appointment->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Appointment created successfully!',
                'appointment' => $appointment
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Exception Creating Appointment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create appointment: ' . $e->getMessage()], 500);
        }
    }

    public function getAvailableSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'employee_id' => 'nullable|integer', // Optional doctor/employee filter
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input', 'messages' => $validator->errors()], 400);
        }

        $date = Carbon::parse($request->date);
        
        // For backward compatibility, return simple time slots
        // This ensures existing frontend implementations continue to work
        $timeSlots = [
            "09:00 AM", "10:00 AM", "11:30 AM",
            "12:00 PM", "02:00 PM", "03:30 PM",
            "05:00 PM", "07:00 PM", "10:00 PM"
        ];

        return response()->json([
            'date' => $date->toDateString(),
            'timeSlots' => $timeSlots
        ]);
    }

    public function update($id, Request $request)
    {
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        // Store original status to compare after update
        $originalStatus = $appointment->status;

        $validator = Validator::make($request->all(), [
            'client_id'    => 'required',
            'employee_id'  => 'required',
            'practice_id'  => 'required',
            'booking_date' => 'required|date',
            'start_time'   => 'required',
            'end_time'     => 'required',
            'status'       => 'nullable|string',
            'notes'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input', 'messages' => $validator->errors()], 400);
        }

        $updatedAppointment = $this->appointmentRepository->update($request->all(), $id);
        
        // Get client for notifications
        $client = \App\Models\Client::find($updatedAppointment->client_id);
        
        // Determine type of notification based on status change
        if ($originalStatus !== $updatedAppointment->status) {
            if ($updatedAppointment->status === 'confirmed') {
                // Status changed to confirmed - send confirmation notification
                $this->sendAppointmentConfirmation($updatedAppointment, $client);
                $this->sendDatabaseNotification($updatedAppointment, $client, 'confirmation');
            } elseif ($updatedAppointment->status === 'canceled') {
                // Status changed to canceled - send cancellation notification
                $this->sendDatabaseNotification($updatedAppointment, $client, 'cancellation');
            } else {
                // Status changed to something else - send update notification
                $this->sendDatabaseNotification($updatedAppointment, $client, 'update');
            }
        } else {
            // Status didn't change but other details might have - send update notification
            $this->sendDatabaseNotification($updatedAppointment, $client, 'update');
        }

        return response()->json([
            'success' => 'Appointment updated successfully!',
            'appointment' => $updatedAppointment
        ]);
    }

    public function destroy($id)
    {
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
        
        // Get client for cancellation notification
        $client = \App\Models\Client::find($appointment->client_id);
        
        // Send cancellation notification before deleting
        $this->sendDatabaseNotification($appointment, $client, 'cancellation');

        $this->appointmentRepository->delete($id);

        return response()->json(['success' => 'Appointment deleted successfully!']);
    }
    
    /**
     * Send appointment confirmation to client via email/SMS
     */
    private function sendAppointmentConfirmation($appointment, $client)
    {
        if (!$client) {
            Log::error('Cannot send confirmation: Client not found for ID ' . $appointment->client_id);
            return;
        }

        // Get doctor/employee name
        $doctor = \App\Models\Employee::find($appointment->employee_id);
        $doctorName = $doctor ? $doctor->emp_first_name . ' ' . $doctor->emp_surname : 'your doctor';
        
        // Format appointment details
        $date = Carbon::parse($appointment->booking_date)->format('l, F j, Y');
        $startTime = Carbon::parse($appointment->start_time)->format('g:i A');
        
        // Email notification
        if ($client->email) {
            try {
                // Check if the Mail class and mailable exist
                if (class_exists('\Mail') && class_exists('\App\Mail\AppointmentConfirmation')) {
                    \Mail::to($client->email)->send(new \App\Mail\AppointmentConfirmation(
                        $client->first_name,
                        $doctorName,
                        $date,
                        $startTime,
                        $appointment->id
                    ));
                    Log::info('Appointment confirmation email sent to: ' . $client->email);
                } else {
                    // Fallback if the mailable doesn't exist yet
                    Log::info('Would send email to ' . $client->email . ' with appointment details for ' . $date . ' at ' . $startTime);
                }
            } catch (\Exception $e) {
                Log::error('Failed to send confirmation email: ' . $e->getMessage());
            }
        }
        
        // SMS notification (placeholder for future implementation)
        if ($client->contact_number) {
            try {
                // Log the intent (will be replaced with actual SMS code later)
                Log::info('Would send SMS to ' . $client->contact_number . ': Your appointment with ' . 
                    $doctorName . ' is confirmed for ' . $date . ' at ' . $startTime . '. Ref: #' . $appointment->id);
            } catch (\Exception $e) {
                Log::error('Failed to send confirmation SMS: ' . $e->getMessage());
            }
        }
    }
    
    /**
     * Send database notification for appointment
     */private function sendDatabaseNotification($appointment, $client, $type)
{
    if (!$client) {
        Log::error('Cannot send database notification: Client not found for ID ' . $appointment->client_id);
        return;
    }
    
    try {
        // Get the doctor/employee name
        $doctor = \App\Models\Employee::find($appointment->employee_id);
        $doctorName = $doctor ? 'Dr. ' . $doctor->emp_first_name . ' ' . $doctor->emp_surname : 'Your Doctor';
        
        // Add doctor name to the appointment object
        $appointmentWithDoctor = clone $appointment;
        $appointmentWithDoctor->doctor_name = $doctorName;
        
        // Send notification with the enhanced appointment object
        $client->notify(new AppointmentNotification($appointmentWithDoctor, $type));
        Log::info("Database notification ({$type}) sent for appointment #{$appointment->id}");
    } catch (\Exception $e) {
        Log::error('Failed to send database notification: ' . $e->getMessage());
    }
}



    /**
     * Process payment for an appointment using a mock payment system
     * 
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function processPayment($id)
    {
        Log::info('📌 Processing mock payment for appointment #' . $id);
        
        try {
            // Find the appointment
            $appointment = $this->appointmentRepository->find($id);

            if (empty($appointment)) {
                Log::error('Payment failed: Appointment #' . $id . ' not found');
                return response()->json([
                    'success' => false, 
                    'message' => 'Appointment not found'
                ], 404);
            }

            // MOCK PAYMENT PROCESSING
            // Simulate a payment by generating a mock transaction ID and receipt
            $mockTransactionId = 'TRANS-' . strtoupper(substr(md5(uniqid()), 0, 10));
            $mockAmount = 105.00; // Fixed price for all appointments in this demo
            
            // Simulate a slight delay like a real payment would have
            sleep(1);
            
            // Update appointment with payment information
            $this->appointmentRepository->update([
                'status' => 'confirmed',
                'notes' => $appointment->notes . "\n\nPayment processed: Transaction ID: {$mockTransactionId}, Amount: €{$mockAmount}"
            ], $id);

            // Get the updated appointment
            $updatedAppointment = $this->appointmentRepository->find($id);

            // Get client details for notifications
            $client = \App\Models\Client::find($appointment->client_id);
            
            // Send confirmation
            $this->sendAppointmentConfirmation($updatedAppointment, $client);
            
            // Send database notification
            $this->sendDatabaseNotification($updatedAppointment, $client, 'confirmation');

            // Generate a mock receipt
            $receipt = [
                'transaction_id' => $mockTransactionId,
                'appointment_id' => $id,
                'amount' => $mockAmount,
                'currency' => 'EUR',
                'date' => now()->format('Y-m-d H:i:s'),
                'payment_method' => 'Credit Card (Simulated)',
                'status' => 'Completed'
            ];

            Log::info('✅ Mock payment processed successfully for appointment #' . $id);

            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully',
                'appointment' => $updatedAppointment,
                'receipt' => $receipt
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Mock payment processing error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Legacy method for payAppointment - Redirects to processPayment
     */
    public function payAppointment($id)
    {
        Log::info('Legacy payAppointment method called, redirecting to processPayment');
        return $this->processPayment($id);
    }

    public function display()
    {
        return view('calendar.display'); // Loads the Blade file
    }

    /**
     * Fetch appointments as JSON for FullCalendar.
     */
    /* public function getAppointments()
    {
        $appointments =  \App\Models\Appointment::all();

        $events = [];

        foreach ($appointments as $appointment) {
            $events[] = [
                'id'    => $appointment->id,
                'title' => "Client #{$appointment->client_id} - {$appointment->status}",
                'start' => "{$appointment->booking_date}T{$appointment->start_time}",
                'end'   => "{$appointment->booking_date}T{$appointment->end_time}",
                'color' => $this->getStatusColor($appointment->status),
            ];
        }

        return response()->json($events);
    } */
    public function getAppointments()
    {
        //$this->view->disable();
        $content = \App\Models\AppointmentEvent::all()->toJson();
        //$content=$json_encode($events);
        return response($content)->withHeaders([
                'Content-Type' => 'application/json',
                'charset' => 'UTF-8'
            ]);
    }
}