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

class AppointmentController extends AppBaseController
{
    /** @var AppointmentRepository */
    private $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepo)
    {
        $this->appointmentRepository = $appointmentRepo;
    }

    /**
     * Display a listing of the Appointment.
     * Handles both AJAX requests (JSON) and regular page loads.
     *
     * @param Request $request
     * @return JsonResponse|Response
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

        // Load the view with appointments
        $appointments = $this->appointmentRepository->all();
        return view('appointments.index')->with('appointments', $appointments);
    }

    /**
     * Get status color for FullCalendar integration.
     * Ensures safe handling of unknown statuses.
     *
     * @param string $status
     * @return string
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
     * Store a newly created Appointment in storage.
     * Handles both AJAX and standard requests.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'client_id'   => 'required|exists:clients,id',
            'employee_id' => 'required|exists:employees,id',
            'practice_id' => 'required|exists:practices,id',
            'booking_date' => 'required|date',
            'start_time'   => 'required|date_format:H:i:s',
            'end_time'     => 'required|date_format:H:i:s|after:start_time',
            'status'       => 'nullable|string',
            'notes'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input', 'messages' => $validator->errors()], 400);
        }

        $appointment = $this->appointmentRepository->create($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => 'Appointment created successfully!', 'appointment' => $appointment]);
        }

        Flash::success('Appointment saved successfully.');
        return redirect(route('appointments.index'));
    }

    /**
     * Show the form for editing the specified Appointment.
     *
     * @param int $id
     * @return Response|JsonResponse
     */
    public function edit($id)
    {
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        return response()->json(['appointment' => $appointment]);
    }

    /**
     * Update the specified Appointment in storage.
     * Supports both AJAX and regular updates.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function update($id, Request $request)
    {
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        $appointment = $this->appointmentRepository->update($request->all(), $id);

        return response()->json(['success' => 'Appointment updated successfully!', 'appointment' => $appointment]);
    }

    /**
     * Remove the specified Appointment from storage.
     * Ensures appointment exists before deletion.
     *
     * @param int $id
     * @return JsonResponse|Response
     */
    public function destroy($id)
    {
        $appointment = $this->appointmentRepository->find($id);

        if (empty($appointment)) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        $this->appointmentRepository->delete($id);

        return response()->json(['success' => 'Appointment deleted successfully!']);
    }
}
