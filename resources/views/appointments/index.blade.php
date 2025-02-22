<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Calendar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: "{{ route('appointments.index') }}", // Fetch appointments from Laravel
                editable: true,
                selectable: true,
                select: function(info) {
                    let client_id = prompt("Enter Client ID:");
                    let employee_id = prompt("Enter Employee ID:");
                    let practice_id = prompt("Enter Practice ID:");

                    if (client_id && employee_id && practice_id) {
                        $.ajax({
                            url: "{{ route('appointments.store') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                client_id: client_id,
                                employee_id: employee_id,
                                practice_id: practice_id,
                                booking_date: info.startStr,
                                start_time: "09:00:00",
                                end_time: "10:00:00",
                                status: "pending"
                            },
                            success: function(response) {
                                alert(response.success);
                                calendar.refetchEvents();
                            }
                        });
                    }
                },
                eventClick: function(info) {
                    if (confirm("Delete this appointment?")) {
                        $.ajax({
                            url: "{{ route('appointments.destroy', '') }}/" + info.event.id,
                            type: "DELETE",
                            data: { _token: "{{ csrf_token() }}" },
                            success: function(response) {
                                alert(response.success);
                                info.event.remove();
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
