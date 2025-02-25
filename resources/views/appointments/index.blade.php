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
        var getAvailableSlotsUrl = @json(route('appointments.available-slots'));
        var listClientsUrl = @json(route('clients.index', ['format' => 'json']));
        var listEmployeesUrl = @json(route('employees.index', ['format' => 'json']));
        var listPracticesUrl = @json(route('practices.index', ['format' => 'json']));
    </script>

    <style>
        /* Calendar Full Height */
        #calendar {
            max-width: 900px;
            margin: 20px auto;
        }
        
        /* Mobile Appointment Edition View */
        .mobile-view {
            max-width: 360px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .status-bar {
            display: flex;
            justify-content: space-between;
            padding: 5px 15px;
            font-size: 12px;
            background-color: #f8f8f8;
        }
        
        .day-selector {
            display: flex;
            border: 2px solid #4f46e5;
            border-radius: 8px;
            overflow: hidden;
            margin: 15px;
        }
        
        .day {
            flex: 1;
            padding: 10px 5px;
            text-align: center;
            cursor: pointer;
        }
        
        .day.selected {
            background-color: #4f46e5;
            color: white;
        }
        
        .time-slot-mobile {
            margin: 10px 15px;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            cursor: pointer;
        }
        
        .time-slot-mobile.selected {
            border: 1px solid #4caf50;
        }
        
        .time-slot-mobile.selected::after {
            content: "✓";
            color: #4caf50;
            font-size: 20px;
            float: right;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Main Calendar View -->
    <div id="calendar-view" class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 mt-6">
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

    <!-- Mobile Appointment Edition View (Initially Hidden) -->
    <div id="appointment-edition" class="mobile-view mt-6 hidden">
        <div class="status-bar">
            <span class="status-time">9:45</span>
            <div class="status-icons">
                <span class="status-icon">📶</span>
                <span class="status-icon">🔋</span>
            </div>
        </div>
        
        <div class="flex items-center p-4 border-b">
            <button id="back-button" class="text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            <h1 class="text-center text-lg font-medium flex-1">Appointment Edition</h1>
            <button class="text-gray-700">•••</button>
        </div>
        
        <div class="p-4">
            <div class="flex justify-center space-x-2 mb-4">
                <select id="month-select" class="border rounded px-3 py-1">
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <select id="year-select" class="border rounded px-3 py-1">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
            
            <div class="day-selector" id="days-container">
                <!-- Days will be added dynamically -->
            </div>
            
            <div class="mt-4">
                <h2 class="text-lg font-semibold mb-2">Select Time</h2>
                <div id="mobile-time-slots">
                    <!-- Time slots will be added dynamically -->
                </div>
            </div>
            
            <div class="mt-4">
                <h2 class="text-lg font-semibold mb-2">Appointment Details</h2>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Doctor</label>
                        <select id="doctor-select" class="w-full border rounded p-2">
                            <option value="">Select Doctor</option>
                            <option value="1">Dr. John Smith</option>
                            <option value="2">Dr. Sarah Johnson</option>
                            <option value="3">Dr. Michael Lee</option>
                            <option value="4">Dr. Emily Rodriguez</option>
                            <option value="5">Dr. Robert Chen</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">Notes</label>
                        <textarea id="notes-input" class="w-full border rounded p-2" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-between p-4 mt-4">
            <button id="cancel-btn" class="px-6 py-2 border border-red-500 text-red-500 rounded-full">Cancel</button>
            <button id="save-btn" class="px-6 py-2 border border-green-500 text-green-500 rounded-full">Save</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global variables for selected date and time
            let selectedDate = '';
            let selectedTime = '';
            
            // Initialize calendar
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
                    selectedDate = info.startStr;
                    loadTimeSlots(selectedDate);
                }
            });

            calendar.render();

            // No need to load dropdown options as we're using static doctors list

            // ✅ Load available time slots dynamically
            function loadTimeSlots(date) {
                console.log("📆 Loading time slots for:", date);
                
                $.ajax({
                    url: getAvailableSlotsUrl,
                    type: "GET",
                    data: { date: date },
                    success: function(response) {
                        let timeSlots = response.timeSlots;
                        let timeSlotsContainer = $("#time-slots");
                        timeSlotsContainer.empty();
                        
                        timeSlots.forEach(slot => {
                            let btn = $(`<button class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg">${slot}</button>`);
                            btn.on("click", function() {
                                $(".bg-blue-500").removeClass("bg-blue-500 text-white").addClass("bg-gray-200 text-gray-800");
                                $(this).removeClass("bg-gray-200 text-gray-800").addClass("bg-blue-500 text-white");
                                selectedTime = slot;
                            });
                            timeSlotsContainer.append(btn);
                        });
                    },
                    error: function(xhr) {
                        console.error("❌ Error fetching time slots:", xhr.responseText);
                    }
                });
            }

            // ✅ Generate days for selector
            function generateDaySelector(year, month) {
                let container = $('#days-container');
                container.empty();
                
                let date = new Date(year, month - 1, 1);
                let currentDay = date.getDay() === 0 ? 7 : date.getDay(); // Convert Sunday from 0 to 7
                
                // Create 4 days starting from Monday of current week
                let monday = new Date(date);
                monday.setDate(monday.getDate() - currentDay + 1);
                
                for (let i = 0; i < 4; i++) {
                    let day = new Date(monday);
                    day.setDate(monday.getDate() + i);
                    
                    let dayEl = $(`
                        <div class="day" data-date="${day.toISOString().split('T')[0]}">
                            <div class="day-number">${day.getDate()}</div>
                            <div class="day-name">${['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][day.getDay()]}</div>
                        </div>
                    `);
                    
                    dayEl.on('click', function() {
                        $('.day').removeClass('selected');
                        $(this).addClass('selected');
                        let newDate = $(this).data('date');
                        loadMobileTimeSlots(newDate);
                    });
                    
                    container.append(dayEl);
                }
                
                // Select first day by default
                $('.day:first-child').addClass('selected');
                loadMobileTimeSlots($('.day:first-child').data('date'));
            }
            
            // ✅ Load mobile time slots
            function loadMobileTimeSlots(date) {
                $.ajax({
                    url: getAvailableSlotsUrl,
                    type: "GET",
                    data: { date: date },
                    success: function(response) {
                        let timeSlots = response.timeSlots;
                        let container = $("#mobile-time-slots");
                        container.empty();
                        
                        timeSlots.forEach(slot => {
                            // Calculate end time (1 hour later)
                            let startTime = new Date(`2025-01-01 ${slot}`);
                            let endTime = new Date(startTime);
                            endTime.setHours(endTime.getHours() + 1);
                            
                            let formattedEndTime = endTime.toLocaleTimeString('en-US', {
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true
                            });
                            
                            let timeSlotEl = $(`<div class="time-slot-mobile">${slot} - ${formattedEndTime}</div>`);
                            
                            timeSlotEl.on('click', function() {
                                $('.time-slot-mobile').removeClass('selected');
                                $(this).addClass('selected');
                                selectedTime = slot;
                            });
                            
                            container.append(timeSlotEl);
                        });
                    },
                    error: function(xhr) {
                        console.error("❌ Error fetching time slots:", xhr.responseText);
                    }
                });
            }

            // ✅ Handle month/year changes
            $('#month-select, #year-select').on('change', function() {
                let year = $('#year-select').val();
                let month = $('#month-select').val();
                generateDaySelector(year, month);
            });

            // ✅ Book Appointment Button - Switch to second wireframe
            $("#book-btn").on("click", function() {
                if (!selectedDate || !selectedTime) {
                    alert("Please select a date and time slot.");
                    return;
                }
                
                // Populate month and year selects based on selected date
                let dateObj = new Date(selectedDate);
                $('#month-select').val(dateObj.getMonth() + 1); // Month is 0-indexed
                $('#year-select').val(dateObj.getFullYear());
                
                // Generate days
                generateDaySelector(dateObj.getFullYear(), dateObj.getMonth() + 1);
                
                // No need to load dropdowns anymore
                
                // Show appointment edition view
                $('#calendar-view').addClass('hidden');
                $('#appointment-edition').removeClass('hidden');
            });
            
            // ✅ Back button - Return to calendar view
            $('#back-button').on('click', function() {
                $('#appointment-edition').addClass('hidden');
                $('#calendar-view').removeClass('hidden');
            });
            
            // ✅ Cancel button - Return to calendar view
            $('#cancel-btn').on('click', function() {
                $('#appointment-edition').addClass('hidden');
                $('#calendar-view').removeClass('hidden');
            });

            // ✅ Save Appointment
            $("#save-btn").on("click", function() {
                let doctor_id = $('#doctor-select').val();
                let notes = $('#notes-input').val();
                
                if (!doctor_id) {
                    alert("Please select a doctor.");
                    return;
                }
                
                let selectedDayEl = $('.day.selected');
                let selectedDateStr = selectedDayEl.data('date');
                let selectedTimeEl = $('.time-slot-mobile.selected');
                
                if (!selectedDateStr || !selectedTimeEl.length) {
                    alert("Please select a date and time slot.");
                    return;
                }
                
                let timeRange = selectedTimeEl.text().split(' - ');
                let startTime = timeRange[0];
                let endTime = timeRange[1];
                
                $.ajax({
                    url: storeAppointmentUrl,
                    type: "POST",
                    data: {
                        _token: csrfToken,
                        client_id: 1, // Default client ID
                        employee_id: doctor_id,
                        practice_id: 1, // Default practice ID
                        booking_date: selectedDateStr,
                        start_time: startTime,
                        end_time: endTime,
                        status: "pending",
                        notes: notes
                    },
                    success: function(response) {
                        if (response.success) {
                            alert("✅ Appointment booked successfully!");
                            calendar.refetchEvents();
                            
                            // Return to calendar view
                            $('#appointment-edition').addClass('hidden');
                            $('#calendar-view').removeClass('hidden');
                        } else {
                            alert("❌ Failed to save appointment.");
                        }
                    },
                    error: function(xhr) {
                        console.error("❌ Error:", xhr.responseText);
                        alert("❌ Error: " + (xhr.responseJSON ? xhr.responseJSON.error : "Failed to book appointment"));
                    }
                });
            });
        });
    </script>

</body>
</html>