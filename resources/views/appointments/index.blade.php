<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Calendar</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- FullCalendar Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <!-- Laravel Routes -->
    <script>
        var appointmentsUrl = @json(route('appointments.index'));
        var storeAppointmentUrl = @json(route('appointments.store'));
        var deleteAppointmentUrl = @json(route('appointments.destroy', ':id'));
        var csrfToken = @json(csrf_token());
    </script>

    <style>
        /* Calendar Full Height */
        #calendar {
            max-width: 900px;
            margin: 20px auto;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 mt-6">
        <h1 class="text-xl font-bold text-gray-800 text-center">Select Date and Time</h1>

        <!-- Calendar -->
        <div id="calendar" class="mt-4"></div>

        <!-- Time Slots -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-gray-700">Available Time Slots</h2>
            <div id="time-slots" class="grid grid-cols-3 gap-2 mt-2">
                <!-- Time slots will be dynamically added here -->
            </div>
        </div>

        <!-- Book Now Button -->
        <button id="book-btn" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg mt-4">
            Book Now
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            if (!calendarEl) {
                console.error("❌ Calendar element not found!");
                return;
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,

                // ✅ Fetch appointments from Laravel
                events: function(fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: appointmentsUrl,
                        type: "GET",
                        success: function(response) {
                            console.log("📅 Events Loaded:", response);
                            successCallback(response);
                        },
                        error: function(xhr) {
                            console.error("❌ Error fetching appointments:", xhr.responseText);
                            failureCallback(xhr);
                        }
                    });
                },

                // ✅ Select a date to show available time slots
                select: function(info) {
                    let selectedDate = info.startStr;
                    loadTimeSlots(selectedDate);
                }
            });

            calendar.render();

            // ✅ Load available time slots dynamically
            function loadTimeSlots(date) {
                let timeSlots = [
                    "09:00 AM", "10:00 AM", "11:30 AM", 
                    "12:00 PM", "02:00 PM", "03:30 PM", 
                    "05:00 PM", "07:00 PM", "10:00 PM"
                ];

                let timeSlotsContainer = $("#time-slots");
                timeSlotsContainer.empty();

                timeSlots.forEach(slot => {
                    let btn = $(`<button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg">${slot}</button>`);
                    btn.on("click", function() {
                        $(".bg-blue-500").removeClass("bg-blue-500 text-white").addClass("bg-gray-200 text-gray-800");
                        $(this).removeClass("bg-gray-200 text-gray-800").addClass("bg-blue-500 text-white");
                        $("#book-btn").data("selected-time", slot);
                    });
                    timeSlotsContainer.append(btn);
                });
            }

            // ✅ Book Appointment
            $("#book-btn").on("click", function() {
                let selectedTime = $(this).data("selected-time");
                if (!selectedTime) {
                    alert("Please select a time slot.");
                    return;
                }

                let client_id = prompt("Enter Client ID:");
                let employee_id = prompt("Enter Employee ID:");
                let practice_id = prompt("Enter Practice ID:");

                if (client_id && employee_id && practice_id) {
                    $.ajax({
                        url: storeAppointmentUrl,
                        type: "POST",
                        data: {
                            _token: csrfToken,
                            client_id: client_id,
                            employee_id: employee_id,
                            practice_id: practice_id,
                            booking_date: $("#calendar").fullCalendar('getDate').format('YYYY-MM-DD'),
                            start_time: selectedTime,
                            end_time: "10:00 AM",
                            status: "pending"
                        },
                        success: function(response) {
                            if (response.success) {
                                alert("✅ Appointment booked successfully!");
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
            });
        });
    </script>

</body>
</html>
