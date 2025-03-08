<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        var paymentUrl = @json(route('appointments.pay', ['id' => ':id']));
    </script>

    <style>
        /* Calendar Full Height */
        #calendar {
            max-width: 900px;
            margin: 20px auto;
        }
        
        /* Selected date styling */
        .fc-day-selected {
            background-color: rgba(59, 130, 246, 0.1) !important;
            border: 2px solid #3b82f6 !important;
            position: relative;
            z-index: 1;
        }
        
        /* Selected time slot styling */
        .time-slot-selected {
            background-color: #3b82f6 !important;
            color: white !important;
        }
        
        /* Make calendar navigation buttons more obvious */
        .fc-header-toolbar button {
            cursor: pointer !important;
            opacity: 1 !important;
        }
        
        /* Explicitly override FullCalendar's date hover effect */
        .fc-highlight {
            background-color: transparent !important;
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
        
        /* Toast Notification */
        .toast-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 20px;
            border-radius: 6px;
            color: white;
            font-weight: bold;
            z-index: 9999;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.3s, transform 0.3s;
            max-width: 300px;
        }
        
        .toast-success {
            background-color: #4caf50;
        }
        
        .toast-error {
            background-color: #f44336;
        }
        
        .toast-show {
            opacity: 1;
            transform: translateY(0);
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

    <!-- Appointment Confirmation View -->
    <div id="confirmation-view" class="mobile-view mt-6 hidden" data-appointment-id="">
        <div class="status-bar">
            <span class="status-time">9:45</span>
            <div class="status-icons">
                <span class="status-icon">📶</span>
                <span class="status-icon">🔋</span>
            </div>
        </div>
        
        <div class="flex items-center p-4 border-b">
            <button id="back-from-confirm" class="text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
            <h1 class="text-center text-lg font-medium flex-1">Appointment</h1>
        </div>
        
        <div class="p-4">
            <div id="confirmation-header">
                <!-- Selected date and time will be displayed here -->
            </div>
            
            <div class="bg-yellow-50 rounded-lg p-4 mb-4">
                <div id="confirm-doctor" class="font-bold text-lg mb-2">Dr. Andrew</div>
                
                <div class="mb-2">
                    <div class="font-medium">Location</div>
                    <div>The Spire, O'Connell Street</div>
                </div>
                
                <div class="mb-2">
                    <div class="font-medium">Date</div>
                    <div id="confirm-date">8th January, 2025</div>
                </div>
                
                <div class="mb-2">
                    <div class="font-medium">Time</div>
                    <div id="confirm-time">13:30 / Tuesday</div>
                </div>
                
                <div class="mb-2">
                    <div class="font-medium">Appointment Type</div>
                    <div>Weekly check-in <span class="float-right">€105</span></div>
                </div>
                
                <div class="border-t border-gray-300 mt-3 pt-2">
                    <div class="font-bold">Total: <span class="float-right">€105</span></div>
                </div>
            </div>
            
            <div class="flex justify-between mb-4">
                <button id="cancel-confirm" class="px-8 py-2 border border-red-500 text-red-500 rounded-full">Cancel</button>
                <button id="edit-confirm" class="px-8 py-2 border border-green-500 text-green-500 rounded-full">Edit</button>
            </div>
            
            <button id="pay-btn" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-4 rounded-lg">
                Pay for Appointment
            </button>
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
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                
                dateClick: function(info) {
                    // Highlight the selected date
                    $(".fc-day").removeClass("fc-day-selected");
                    $(info.dayEl).addClass("fc-day-selected");
                    
                    // Store the selected date
                    selectedDate = info.dateStr;
                    console.log("Date selected:", selectedDate);
                    
                    // Load time slots for this date
                    loadTimeSlots(selectedDate);
                    
                    // Make sure the Book Now button is updated with this date
                    $("#book-btn").data("selected-date", selectedDate);
                },

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
                    console.log("Date selected via select:", selectedDate);
                    
                    // Highlight the selected date
                    $(".fc-day").removeClass("fc-day-selected");
                    $(".fc-day[data-date='" + selectedDate + "']").addClass("fc-day-selected");
                    
                    loadTimeSlots(selectedDate);
                }
            });

            // Function to update calendar cell events after navigation
            function updateCalendarCellEvents() {
                // Make all days clickable
                $('.fc-daygrid-day').addClass('selectable-day');
                $('.fc-daygrid-day').css('cursor', 'pointer');
                
                console.log("Calendar cells updated:", $('.fc-daygrid-day').length);
            }
            
            // ✅ Initialize the calendar with all events enabled
            calendar.render();
            
            // Set up event listeners after calendar is rendered
            calendar.on('datesSet', function() {
                console.log("Calendar dates changed, updating cell events");
                setTimeout(updateCalendarCellEvents, 100);
            });
            
            // Initial setup
            setTimeout(updateCalendarCellEvents, 1000);

            // No need to load dropdown options as we're using static doctors list

            // After calendar renders, add class to all calendar day cells for better selection
            setTimeout(() => {
                // Make all days clickable
                $('.fc-daygrid-day').addClass('selectable-day');
                
                // Add click handler directly to calendar days
                $(document).on('click', '.selectable-day', function() {
                    let dateAttr = $(this).data('date');
                    if (dateAttr) {
                        $(".fc-day").removeClass("fc-day-selected");
                        $(this).addClass("fc-day-selected");
                        
                        selectedDate = dateAttr;
                        console.log("Date selected via delegation:", selectedDate);
                        
                        // Load time slots for this date
                        loadTimeSlots(selectedDate);
                    }
                });
                
                // Ensure the calendar navigation buttons work
                $('.fc-prev-button, .fc-next-button, .fc-today-button').on('click', function() {
                    console.log("Calendar navigation clicked");
                    
                    // Reset selected date to ensure clean state
                    selectedDate = '';
                    selectedTime = '';
                    
                    // Reset highlighting
                    $(".fc-day").removeClass("fc-day-selected");
                    $(".time-slot").removeClass("time-slot-selected bg-blue-500 text-white").addClass("bg-gray-200 text-gray-800");
                    
                    // After navigation, re-add the selectable class to the new days
                    setTimeout(() => {
                        $('.fc-daygrid-day').addClass('selectable-day');
                    }, 200);
                });
            }, 1000);

            // ✅ Notification system
            function showNotification(message, type) {
                // Remove any existing notifications
                $('.toast-notification').remove();
                
                // Create new notification
                const notification = $(`<div class="toast-notification toast-${type}">${message}</div>`);
                $('body').append(notification);
                
                // Show notification
                setTimeout(() => {
                    notification.addClass('toast-show');
                }, 100);
                
                // Auto hide after 4 seconds
                setTimeout(() => {
                    notification.removeClass('toast-show');
                    
                    // Remove from DOM after fade out
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 4000);
            }
            
            // Function to restore selected date and time
            function restoreSelections() {
                // If a date was selected, re-highlight it
                if (selectedDate) {
                    setTimeout(() => {
                        $('.fc-day[data-date="' + selectedDate + '"]').addClass('fc-day-selected');
                    }, 100);
                }
                
                // If a time was selected, re-highlight it
                if (selectedTime) {
                    setTimeout(() => {
                        $('.time-slot[data-time="' + selectedTime + '"]').removeClass("bg-gray-200 text-gray-800").addClass("time-slot-selected bg-blue-500 text-white");
                    }, 100);
                }
            }
            
            function loadTimeSlots(date) {
                if (!date) {
                    console.error("❌ No date provided to loadTimeSlots");
                    return;
                }
                console.log("📆 Loading time slots for:", date);
                
                // Get the selected doctor if any
                let doctorId = $('#doctor-select').val() || null;
                
                $.ajax({
                    url: getAvailableSlotsUrl,
                    type: "GET",
                    data: { 
                        date: date,
                        employee_id: doctorId
                    },
                    success: function(response) {
                        console.log("Time slots response:", response); // Debug
                        
                        let timeSlots = response.timeSlots;
                        let timeSlotsContainer = $("#time-slots");
                        timeSlotsContainer.empty();
                        
                        if (!timeSlots || timeSlots.length === 0) {
                            timeSlotsContainer.append('<p class="col-span-3 text-center py-4 text-gray-500">No available time slots for this date.</p>');
                            return;
                        }
                        
                        // Check if timeSlots is an array of strings (old format) or objects (new format)
                        if (typeof timeSlots[0] === 'string') {
                            // Old format
                            timeSlots.forEach(slot => {
                                let btn = $(`<button class="time-slot bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg" data-time="${slot}">${slot}</button>`);
                                btn.on("click", function() {
                                    $(".time-slot").removeClass("time-slot-selected bg-blue-500 text-white").addClass("bg-gray-200 text-gray-800");
                                    $(this).removeClass("bg-gray-200 text-gray-800").addClass("time-slot-selected bg-blue-500 text-white");
                                    selectedTime = slot;
                                    console.log("Time selected:", selectedTime, "Current date:", selectedDate);
                                    
                                    // Make sure the Book Now button has both date and time
                                    $("#book-btn").data("selected-time", selectedTime);
                                });
                                timeSlotsContainer.append(btn);
                            });
                        } else {
                            // New format with availability status
                            timeSlots.forEach(slot => {
                                if (slot.available) {
                                    let btn = $(`<button class="time-slot bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg" data-time="${slot.time}">${slot.time}</button>`);
                                    btn.on("click", function() {
                                        $(".time-slot").removeClass("time-slot-selected bg-blue-500 text-white").addClass("bg-gray-200 text-gray-800");
                                        $(this).removeClass("bg-gray-200 text-gray-800").addClass("time-slot-selected bg-blue-500 text-white");
                                        selectedTime = slot.time;
                                        console.log("Time selected:", selectedTime, "Current date:", selectedDate);
                                        
                                        // Make sure the Book Now button has both date and time
                                        $("#book-btn").data("selected-time", selectedTime);
                                    });
                                    timeSlotsContainer.append(btn);
                                } else {
                                    // Create a disabled button for booked slots
                                    let disabledBtn = $(`<button class="bg-gray-100 text-gray-400 px-4 py-2 rounded-lg cursor-not-allowed opacity-60" disabled>${slot.time}</button>`);
                                    timeSlotsContainer.append(disabledBtn);
                                }
                            });
                        }
                        
                        // Restore any previously selected time slot
                        restoreSelections();
                    },
                    error: function(xhr) {
                        console.error("❌ Error fetching time slots:", xhr.responseText);
                        $("#time-slots").empty().append(
                            '<p class="col-span-3 text-center py-4 text-red-500">Error loading time slots. Please try again.</p>'
                        );
                    }
                });
            }

            // ✅ Generate days for selector
            function generateDaySelector(year, month, selectedDay) {
                let container = $('#days-container');
                container.empty();
                
                let currentDate = new Date(year, month - 1, 1);
                let daysInMonth = new Date(year, month, 0).getDate();
                
                // Find the day to center around (the selected day)
                let centerDay = selectedDay || Math.min(15, daysInMonth);
                
                // Calculate start day (2 days before center, but ensure it's in the month)
                let startDay = Math.max(1, centerDay - 2);
                
                // Create 4 days starting from startDay
                for (let i = 0; i < 4; i++) {
                    let dayNum = startDay + i;
                    
                    // Skip if we exceed days in month
                    if (dayNum > daysInMonth) break;
                    
                    let dayDate = new Date(year, month - 1, dayNum);
                    let formattedDate = dayDate.toISOString().split('T')[0];
                    
                    let dayEl = $(`
                        <div class="day" data-date="${formattedDate}">
                            <div class="day-number">${dayNum}</div>
                            <div class="day-name">${['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][dayDate.getDay()]}</div>
                        </div>
                    `);
                    
                    // Mark as selected if it matches selectedDay
                    if (dayNum === selectedDay) {
                        dayEl.addClass('selected');
                    }
                    
                    dayEl.on('click', function() {
                        $('.day').removeClass('selected');
                        $(this).addClass('selected');
                        let newDate = $(this).data('date');
                        selectedDate = newDate; // Update the selectedDate global variable
                        loadMobileTimeSlots(newDate);
                    });
                    
                    container.append(dayEl);
                }
                
                // Load time slots for the selected day
                let selectedDayEl = $('.day.selected');
                if (selectedDayEl.length) {
                    let dateStr = selectedDayEl.data('date');
                    loadMobileTimeSlots(dateStr);
                }
            }
            
            // ✅ Load mobile time slots
            function loadMobileTimeSlots(date) {
                if (!date) {
                    console.error("No date provided to loadMobileTimeSlots");
                    return;
                }
                
                console.log("Loading mobile time slots for:", date);
                
                // Get the selected doctor
                let doctorId = $('#doctor-select').val() || null;
                
                $.ajax({
                    url: getAvailableSlotsUrl,
                    type: "GET",
                    data: { 
                        date: date,
                        employee_id: doctorId
                    },
                    success: function(response) {
                        console.log("Mobile time slots response:", response); // Debug
                        
                        let timeSlots = response.timeSlots;
                        let container = $("#mobile-time-slots");
                        container.empty();
                        
                        if (!timeSlots || timeSlots.length === 0) {
                            container.append('<p class="text-center py-4 text-gray-500">No available time slots for this date.</p>');
                            return;
                        }
                        
                        // Check if timeSlots is an array of strings (old format) or objects (new format)
                        if (typeof timeSlots[0] === 'string') {
                            // Old format - simple time strings
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
                                
                                let timeLabel = `${slot} - ${formattedEndTime}`;
                                let timeSlotEl = $(`<div class="time-slot-mobile" data-time="${slot}">${timeLabel}</div>`);
                                
                                // Check if this matches our selected time from the main view
                                if (selectedTime === slot) {
                                    timeSlotEl.addClass('selected');
                                }
                                
                                timeSlotEl.on('click', function() {
                                    $('.time-slot-mobile').removeClass('selected');
                                    $(this).addClass('selected');
                                    selectedTime = slot;
                                });
                                
                                container.append(timeSlotEl);
                            });
                        } else {
                            // New format with availability information
                            timeSlots.forEach(slot => {
                                // Calculate end time (1 hour later)
                                let startTime = new Date(`2025-01-01 ${slot.time}`);
                                let endTime = new Date(startTime);
                                endTime.setHours(endTime.getHours() + 1);
                                
                                let formattedEndTime = endTime.toLocaleTimeString('en-US', {
                                    hour: 'numeric',
                                    minute: '2-digit',
                                    hour12: true
                                });
                                
                                let timeLabel = `${slot.time} - ${formattedEndTime}`;
                                
                                if (slot.available) {
                                    let timeSlotEl = $(`<div class="time-slot-mobile" data-time="${slot.time}">${timeLabel}</div>`);
                                    
                                    // Check if this matches our selected time from the main view
                                    if (selectedTime === slot.time) {
                                        timeSlotEl.addClass('selected');
                                    }
                                    
                                    timeSlotEl.on('click', function() {
                                        $('.time-slot-mobile').removeClass('selected');
                                        $(this).addClass('selected');
                                        electedTime = slot.time;
                                    });
                                    
                                    container.append(timeSlotEl);
                                } else {
                                    // Create a disabled slot for booked times
                                    let disabledSlot = $(`<div class="time-slot-mobile opacity-50 bg-gray-100 cursor-not-allowed">${timeLabel} <span class="text-red-500 float-right">Unavailable</span></div>`);
                                    container.append(disabledSlot);
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error("❌ Error fetching time slots:", xhr.responseText);
                        $("#mobile-time-slots").empty().append(
                            '<p class="text-center py-4 text-red-500">Error loading time slots. Please try again.</p>'
                        );
                    }
                });
            }

            // When month/year changes, regenerate day selector
            $('#month-select, #year-select').on('change', function() {
                let year = parseInt($('#year-select').val());
                let month = parseInt($('#month-select').val());
                
                // Get currently selected day if possible
                let selectedDayEl = $('.day.selected');
                let selectedDay = selectedDayEl.length ? 
                    parseInt(selectedDayEl.find('.day-number').text()) : null;
                
                // Check if selected day is valid in new month
                let daysInNewMonth = new Date(year, month, 0).getDate();
                if (selectedDay && selectedDay > daysInNewMonth) {
                    selectedDay = daysInNewMonth; // Adjust if month doesn't have as many days
                }
                
                generateDaySelector(year, month, selectedDay);
            });

            // When doctor changes, refresh time slots
            $('#doctor-select').on('change', function() {
                if (selectedDate) {
                    loadTimeSlots(selectedDate);
                }
                
                // Also reload mobile time slots if in that view
                let selectedDay = $('.day.selected');
                if (selectedDay.length) {
                    loadMobileTimeSlots(selectedDay.data('date'));
                }
            });
            
            // ✅ Book Appointment Button - Switch to second wireframe
            $("#book-btn").on("click", function() {
                if (!selectedDate || !selectedTime) {
                    alert("Please select a date and time slot.");
                    return;
                }
                
                console.log("Booking with date:", selectedDate, "and time:", selectedTime);
                
                // Parse the selected date to get day, month, year
                let dateObj = new Date(selectedDate);
                let selectedDay = dateObj.getDate();
                let selectedMonth = dateObj.getMonth() + 1; // Month is 0-indexed
                let selectedYear = dateObj.getFullYear();
                
                console.log("Selected day:", selectedDay, "month:", selectedMonth, "year:", selectedYear);
                
                // Set month and year in the select inputs
                $('#month-select').val(selectedMonth);
                $('#year-select').val(selectedYear);
                
                // Generate days centered around the selected date
                generateDaySelector(selectedYear, selectedMonth, selectedDay);
                
                // No need to load dropdowns
                
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
            
            // ✅ Functions for confirmation view
            function updateConfirmationView(date, time, doctorId) {
                // Format the date
                let dateObj = new Date(date);
                let formattedDate = formatDate(dateObj);
                
                // Get day of week
                let dayOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][dateObj.getDay()];
                
                // Get the doctor name
                let doctorName = $('#doctor-select option:selected').text();
                
                // Update confirmation view
                $('#confirm-doctor').text(doctorName);
                $('#confirm-date').text(formattedDate);
                $('#confirm-time').text(time + ' / ' + dayOfWeek);
                
                // Display the selected date and time prominently at the top of the confirmation screen
                $('#confirmation-header').html(`
                    <div class="mb-2 text-center">
                        <div class="text-sm text-gray-600">Selected Date & Time</div>
                        <div class="text-xl font-bold">${formattedDate} at ${time}</div>
                    </div>
                `);
            }
            
            function formatDate(date) {
                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                
                let day = date.getDate();
                let month = months[date.getMonth()];
                let year = date.getFullYear();
                
                // Add ordinal suffix to day
                let suffix = getOrdinalSuffix(day);
                
                return day + suffix + ' ' + month + ', ' + year;
            }
            
            function getOrdinalSuffix(day) {
                if (day > 3 && day < 21) return 'th';
                switch (day % 10) {
                    case 1:  return 'st';
                    case 2:  return 'nd';
                    case 3:  return 'rd';
                    default: return 'th';
                }
            }
            
            // ✅ Confirmation view buttons
            $('#back-from-confirm, #cancel-confirm').on('click', function() {
                $('#confirmation-view').addClass('hidden');
                $('#calendar-view').removeClass('hidden');
            });
            
            $('#edit-confirm').on('click', function() {
                $('#confirmation-view').addClass('hidden');
                $('#appointment-edition').removeClass('hidden');
            });
            
            // ✅ Payment button - Process payment for appointment
            $('#pay-btn').on('click', function() {
                // Get the appointment ID from the confirmation view
                let appointmentId = $('#confirmation-view').data('appointment-id');
                if (!appointmentId) {
                    showNotification("No appointment selected", "error");
                    return;
                }
                
                // Replace :id in the route template with the actual ID
                let payUrl = paymentUrl.replace(':id', appointmentId);
                
                fetch(payUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        showNotification("✅ Payment successful!", "success");
                        
                        // Hide confirmation view and return to calendar
                        $('#confirmation-view').addClass('hidden');
                        $('#calendar-view').removeClass('hidden');
                        
                        // Refresh calendar events
                        calendar.refetchEvents();
                    } else {
                        showNotification("❌ Payment failed: " + data.message, "error");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification("❌ An error occurred during payment", "error");
                });
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
                if (!selectedDayEl.length) {
                    alert("Please select a day.");
                    return;
                }
                
                let selectedTimeEl = $('.time-slot-mobile.selected');
                if (!selectedTimeEl.length) {
                    alert("Please select a time slot.");
                    return;
                }
                
                let selectedDateStr = selectedDayEl.data('date');
                let timeRange = selectedTimeEl.text().split(' - ');
                let startTime = timeRange[0].trim();
                
                // Calculate end time based on start time (add 45 minutes)
                let startDateTime = new Date(`2025-01-01 ${startTime}`);
                let endDateTime = new Date(startDateTime);
                endDateTime.setMinutes(endDateTime.getMinutes() + 45);
                
                let endTime = endDateTime.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });
                
                console.log("Submitting appointment:", {
                    date: selectedDateStr,
                    start: startTime,
                    end: endTime,
                    doctor: doctor_id
                });
                
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
                            // Store the appointment ID in the confirmation view
                            $('#confirmation-view').data('appointment-id', response.appointment.id);
                            
                            // Show confirmation view instead of alert
                            updateConfirmationView(selectedDateStr, startTime, doctor_id);
                            
                            // Hide appointment edition and show confirmation
                            $('#appointment-edition').addClass('hidden');
                            $('#confirmation-view').removeClass('hidden');
                            
                            // Show success toast notification
                            showNotification("✅ Appointment booked successfully!", "success");
                            
                            calendar.refetchEvents();
                        } else {
                            showNotification("❌ Failed to save appointment.", "error");
                        }
                    },
                    error: function(xhr) {
                        console.error("❌ Error:", xhr.responseText);
                        
                        let errorMessage = "Failed to book appointment";
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        
                        showNotification("❌ Error: " + errorMessage, "error");
                    }
                });
            });
        });
    </script>
</body>
</html>