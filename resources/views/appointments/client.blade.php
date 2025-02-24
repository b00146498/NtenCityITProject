<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Laravel Routes -->
    <script>
        var clientAppointmentsUrl = @json(route('appointments.client'));
        var deleteAppointmentUrl = @json(route('appointments.destroy', ':id'));
        var csrfToken = @json(csrf_token());
    </script>
</head>
<body class="bg-gray-100">

    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 mt-6">
        <h1 class="text-xl font-bold text-gray-800 text-center">My Appointments</h1>

        <!-- Filters (Upcoming, Completed, Canceled) -->
        <div class="flex justify-between mt-4">
            <button class="filter-btn bg-gray-300 px-4 py-2 rounded-lg" data-status="upcoming">Upcoming</button>
            <button class="filter-btn bg-gray-300 px-4 py-2 rounded-lg" data-status="completed">Completed</button>
            <button class="filter-btn bg-gray-300 px-4 py-2 rounded-lg" data-status="canceled">Canceled</button>
        </div>

        <!-- Appointments List -->
        <div id="appointments-list" class="mt-4">
            <!-- Appointments will be dynamically added here -->
        </div>
    </div>

    <script>
        $(document).ready(function() {
            fetchAppointments();

            // ✅ Fetch client appointments
            function fetchAppointments(status = "upcoming") {
                $.ajax({
                    url: clientAppointmentsUrl,
                    type: "GET",
                    data: { status: status },
                    success: function(response) {
                        let appointmentsList = $("#appointments-list");
                        appointmentsList.empty();

                        if (response.length === 0) {
                            appointmentsList.append("<p class='text-center text-gray-500'>No appointments found.</p>");
                            return;
                        }

                        response.forEach(appointment => {
                            let appointmentCard = `
                                <div class="bg-gray-100 p-4 rounded-lg shadow-md mt-2">
                                    <h3 class="font-bold text-gray-700">${appointment.title}</h3>
                                    <p class="text-sm text-gray-600">${appointment.start} - ${appointment.end}</p>
                                    <div class="flex justify-between mt-2">
                                        <button class="view-btn bg-black text-white px-3 py-1 rounded">View</button>
                                        <button class="edit-btn bg-green-500 text-white px-3 py-1 rounded" data-id="${appointment.id}">Edit</button>
                                        <button class="cancel-btn bg-red-500 text-white px-3 py-1 rounded" data-id="${appointment.id}">Cancel</button>
                                    </div>
                                </div>
                            `;
                            appointmentsList.append(appointmentCard);
                        });
                    },
                    error: function(xhr) {
                        alert("❌ Error fetching appointments.");
                    }
                });
            }

            // ✅ Handle filters
            $(".filter-btn").on("click", function() {
                let status = $(this).data("status");
                fetchAppointments(status);
            });

            // ✅ Cancel an appointment
            $(document).on("click", ".cancel-btn", function() {
                let appointmentId = $(this).data("id");
                if (confirm("Are you sure you want to cancel this appointment?")) {
                    $.ajax({
                        url: deleteAppointmentUrl.replace(':id', appointmentId),
                        type: "DELETE",
                        data: { _token: csrfToken },
                        success: function(response) {
                            alert("✅ Appointment canceled!");
                            fetchAppointments();
                        },
                        error: function(xhr) {
                            alert("❌ Error canceling appointment.");
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>
