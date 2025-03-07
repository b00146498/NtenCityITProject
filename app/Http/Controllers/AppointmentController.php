<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Repositories\AppointmentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Flash;
use Response;
use Carbon\Carbon;

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
        
        /* 
        // Uncomment this code when you're ready to implement the availability checking
        // This is the advanced implementation that checks real database availability
        
        // Define all possible time slots
        $allTimeSlots = [
            "09:00 AM" => ["start" => "09:00:00", "end" => "10:00:00"],
            "10:00 AM" => ["start" => "10:00:00", "end" => "11:00:00"],
            "11:30 AM" => ["start" => "11:30:00", "end" => "12:30:00"],
            "12:00 PM" => ["start" => "12:00:00", "end" => "13:00:00"],
            "02:00 PM" => ["start" => "14:00:00", "end" => "15:00:00"],
            "03:30 PM" => ["start" => "15:30:00", "end" => "16:30:00"],
            "05:00 PM" => ["start" => "17:00:00", "end" => "18:00:00"],
            "07:00 PM" => ["start" => "19:00:00", "end" => "20:00:00"],
            "10:00 PM" => ["start" => "22:00:00", "end" => "23:00:00"]
        ];
        
        // Query for existing appointments on the selected date
        $query = $this->appointmentRepository->makeModel()
            ->newQuery()
            ->where('booking_date', $date->toDateString())
            ->where('status', '!=', 'canceled');
            
        // If a specific employee (doctor) is selected, filter by that employee
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        
        $existingAppointments = $query->get(['start_time', 'end_time', 'employee_id']);
        
        // Convert existing appointments to array of unavailable slots
        $bookedSlots = [];
        foreach ($existingAppointments as $appointment) {
            $startTime = Carbon::parse($appointment->start_time)->format('H:i:s');
            foreach ($allTimeSlots as $displayTime => $timeRange) {
                // If this slot overlaps with an existing appointment, mark it as booked
                if ($startTime === $timeRange['start']) {
                    if (!isset($bookedSlots[$displayTime])) {
                        $bookedSlots[$displayTime] = [];
                    }
                    $bookedSlots[$displayTime][] = $appointment->employee_id;
                }
            }
        }
        
        // Build the response with available and unavailable slots
        $result = [];
        foreach ($allTimeSlots as $displayTime => $timeRange) {
            $isBooked = false;
            $bookedByDoctor = null;
            
            // Check if this slot is booked by the selected doctor
            if ($request->filled('employee_id') && 
                isset($bookedSlots[$displayTime]) && 
                in_array($request->employee_id, $bookedSlots[$displayTime])) {
                $isBooked = true;
                $bookedByDoctor = $request->employee_id;
            }
            
            $result[] = [
                'time' => $displayTime, 
                'available' => !$isBooked,
                'booked_by_doctor' => $bookedByDoctor
            ];
        }
        
        return response()->json([
            'date' => $date->toDateString(),
            'timeSlots' => $result
        ]);
        */
    }

    public function update($id, Request $request)
    {
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

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

        $appointment = $this->appointmentRepository->update($request->all(), $id);

        return response()->json([
            'success' => 'Appointment updated successfully!',
            'appointment' => $appointment
        ]);
    }

    public function destroy($id)
    {
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        $this->appointmentRepository->delete($id);

        return response()->json(['success' => 'Appointment deleted successfully!']);
    }
    
    /**
     * Send appointment confirmation to client
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
                
                // Uncomment and configure when SMS service is ready
                /*
                $message = "Your appointment with {$doctorName} is confirmed for {$date} at {$startTime}. Ref: #{$appointment->id}";
                
                // If using a service class
                app(\App\Services\SmsService::class)->send($client->contact_number, $message);
                
                // Or directly with a provider like Twilio
                $twilioSid = config('services.twilio.sid');
                $twilioToken = config('services.twilio.token');
                $twilioFrom = config('services.twilio.from');
                
                $twilio = new \Twilio\Rest\Client($twilioSid, $twilioToken);
                $twilio->messages->create(
                    $client->contact_number,
                    [
                        'from' => $twilioFrom,
                        'body' => $message
                    ]
                );
                */
            } catch (\Exception $e) {
                Log::error('Failed to send confirmation SMS: ' . $e->getMessage());
            }
        }
    }
}