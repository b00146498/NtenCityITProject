<div id="fullCalModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button> 
        <h4 class="modal-title">Create Appointment</h4>       
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form id="createAppointmentForm" action="{{ route('appointments.store') }}" method="post">
            @csrf

            <div class="form-group">
              <label for="client_id">Client</label>
              <select class="form-control" id="client_id" name="client_id" required>
                <option value="">Select a Client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->first_name }} {{ $client->surname }}</option> 
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="employee_id">Employee</label>
              <select class="form-control" id="employee_id" name="employee_id" required>
                <option value="">Select an Employee</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->emp_first_name }} {{ $employee->emp_surname }}</option> 
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="bookingDate">Booking Date</label>
              <input type="text" class="form-control" id="bookingDate" name="booking_date" required />
            </div>

            <div class="form-group">
              <label for="starttime">Start Time</label>
              <input type="text" class="form-control" id="starttime" name="start_time" required />
            </div>

            <div class="form-group">
              <label for="endtime">End Time</label>
              <input type="text" class="form-control" id="endtime" name="end_time" required />
            </div>

            <div class="form-group">
              <label for="status">Status</label>
              <select class="form-control" id="status" name="status">
                <option value="confirmed">Confirmed</option>
                <option value="pending">Pending</option>
                <option value="canceled">Canceled</option>
              </select>
            </div>

            <div class="modal-footer">
              <button type="submit" id="submitButton" class="btn btn-primary">Create Appointment</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </form>

          <!-- ✅ View Appointment Section (Hidden by Default) -->
          <div id="viewAppointmentSection" style="display: none; margin-top: 20px;">
            <h4 class="text-center" style="color: #c9a86a; font-weight: bold;">✅ Appointment Saved!</h4>
            <p><strong>Client:</strong> <span id="viewClient"></span></p>
            <p><strong>Employee:</strong> <span id="viewEmployee"></span></p>
            <p><strong>Practice:</strong> <span id="viewPractice"></span></p>
            <p><strong>Date:</strong> <span id="viewDate"></span></p>
            <p><strong>Start Time:</strong> <span id="viewStartTime"></span></p>
            <p><strong>End Time:</strong> <span id="viewEndTime"></span></p>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
