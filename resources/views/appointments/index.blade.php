<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Calendar</title>

    <!-- jQuery (Make sure this loads first) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- FullCalendar Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">

    <!-- FullCalendar JS (After jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
</head>
<body>

    <h1>Appointments Calendar</h1>
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            if (!calendarEl) {
                console.error("❌ Calendar element not found!");
                return;
            }

            // Laravel Route URLs (Pass them from Blade)
            var appointmentsUrl = "{{ route('appointments.index') }}";
            var storeAppointmentUrl = "{{ route('appointments.store') }}";
            var deleteAppointmentUrl = "{{ route('appointments.destroy', '') }}";

            // CSRF Token (Required for Laravel POST/DELETE)
            var csrfToken = "{{ csrf_token() }}";

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: function(fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: appointmentsUrl,
                        type: "GET",
                        success: function(response) {
                            successCallback(response);
                        },
                        error: function(xhr) {
                            console.error("❌ Error fetching appointments:", xhr.responseText);
                            failureCallback(xhr);
                        }
                    });
                },
                editable: true,
                selectable: true,
                select: function(info) {
                    let client_id = prompt("Enter Client ID:");
                    let employee_id = prompt("Enter Employee ID:");
                    let practice_id = prompt("Enter Practice ID:");

                    if (client_id && employee_id && practice_id) {
                        $.ajax({
                            url: storeAppointmentUrl,
                            type: "POST",
                            data: JSON.stringify({
                                _token: csrfToken,
                                client_id: client_id,
                                employee_id: employee_id,
                                practice_id: practice_id,
                                booking_date: info.startStr,
                                start_time: "09:00:00",
                                end_time: "10:00:00",
                                status: "pending"
                            }),
                            contentType: "application/json",
                            success: function(response) {
                                if (response.success) {
                                    alert("✅ Appointment saved successfully!");
                                    calendar.refetchEvents();
                                } else {
                                    alert("❌ Failed to save appointment.");
                                }
                            },
                            error: function(xhr) {
                                alert("❌ Error: " + xhr.responseText);
                            }
                        });
                    }
                },
                eventClick: function(info) {
                    if (confirm("Are you sure you want to delete this appointment?")) {
                        $.ajax({
                            url: deleteAppointmentUrl.replace('', info.event.id),
                            type: "DELETE",
                            data: JSON.stringify({ _token: csrfToken }),
                            contentType: "application/json",
                            success: function(response) {
                                if (response.success) {
                                    alert("✅ Appointment deleted successfully!");
                                    info.event.remove();
                                } else {
                                    alert("❌ Failed to delete appointment.");
                                }
                            },
                            error: function(xhr) {
                                alert("❌ Error: " + xhr.responseText);
                            }
                        });
                    }
                }
            });

            calendar.render();
        });
    </script>

</body>
</html>
