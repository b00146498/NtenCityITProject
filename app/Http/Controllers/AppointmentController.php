<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Repositories\AppointmentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
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

    /**
     * Display client-focused appointments.
     */
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

    /**
     * Get color for FullCalendar based on appointment status.
     */
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

    /**
     * Store a new client appointment.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id'    => 'required|exists:clients,id',
            'employee_id'  => 'required|exists:employees,id',
            'practice_id'  => 'required|exists:practices,id',
            'booking_date' => 'required|date',
            'start_time'   => 'required|date_format:H:i A',
            'end_time'     => 'required|date_format:H:i A|after:start_time',
            'status'       => 'nullable|string',
            'notes'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input', 'messages' => $validator->errors()], 400);
        }

        $appointment = $this->appointmentRepository->create($request->all());

        return response()->json([
            'success' => 'Appointment created successfully!',
            'appointment' => $appointment
        ]);
    }

    /**
     * Fetch available time slots for a given date.
     */
    public function getAvailableSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input', 'messages' => $validator->errors()], 400);
        }

        $date = Carbon::parse($request->date);
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

    /**
     * Update an appointment.
     */
    public function update($id, Request $request)
    {
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'client_id'    => 'required|exists:clients,id',
            'employee_id'  => 'required|exists:employees,id',
            'practice_id'  => 'required|exists:practices,id',
            'booking_date' => 'required|date',
            'start_time'   => 'required|date_format:H:i A',
            'end_time'     => 'required|date_format:H:i A|after:start_time',
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

    /**
     * Cancel an appointment.
     */
    public function cancel($id)
    {
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        $appointment->update(['status' => 'canceled']);

        return response()->json(['success' => 'Appointment canceled successfully!']);
    }
}
