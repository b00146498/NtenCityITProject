@foreach ($appointments as $appointment)
<div class="appointment-card {{ $appointment->status === 'completed' ? 'completed' : '' }}">
        <div class="appointment-left">
            <div class="appointment-time-full">
                <i class="fas fa-calendar-alt calendar-icon"></i>
                <span class="datetime-text">
                    {{ \Carbon\Carbon::parse($appointment->booking_date)->format('D, M j Y') }},
                    {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} – 
                    {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                </span>
            </div>
        </div>

        <div class="appointment-right">
            <div class="trainer-name">
                {{ $appointment->employee->emp_first_name ?? 'No' }}
                {{ $appointment->employee->emp_surname ?? 'Trainer' }}
            </div>
            <div class="trainer-role">Physiotherapist</div>

            <div class="action-buttons">
							<a href="javascript:void(0);" class="btn-view"
			   onclick="openModal({
				   date: '{{ \Carbon\Carbon::parse($appointment->booking_date)->format('D, M j Y') }}',
				   time: '{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}',
				   trainer: '{{ $appointment->employee->emp_first_name }} {{ $appointment->employee->emp_surname }}',
				   notes: '{{ $appointment->notes }}'
			   })">View</a>
						<form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
			@csrf
			@method('PATCH')
			<button type="submit" class="btn-cancel">Cancel</button>
		</form>

            </div>
        </div>
    </div>
@endforeach

<style>
.appointment-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f9f9f9;
    padding: 16px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    flex-wrap: wrap;
    min-height: 110px;
}

.appointment-left {
    flex: 2;
    display: flex;
    align-items: center;
}

.appointment-time-full {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
    color: #444;
    flex-wrap: wrap;
}

.calendar-icon {
    color: #C96E04;
    font-size: 1.1rem;
    margin-right: 4px;
}

.datetime-text {
    font-weight: 500;
    color: #333;
}

.appointment-right {
    flex: 2;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.trainer-name {
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 2px;
    color: #333;
}

.trainer-role {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 10px;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

.btn-view {
    background: black;
    color: white;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 0.85rem;
    text-decoration: none;
    line-height: 1;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
}


.btn-view:hover {
    background: #222;
    color: white;
    text-decoration: none;
}

.btn-cancel {
    background: white;
    border: 2px solid #E63946;
    color: #E63946;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 0.85rem;
    text-decoration: none;
    line-height: 1;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
}


.btn-cancel:hover {
    background: #ffeaea;
}

/* Completed appointment card style */
.appointment-card.completed {
    background-color: #f1fdf5; /* soft green tone */
    border-left: 5px solid #28a745; /* green accent bar */
    opacity: 0.95;
    position: relative;
}

.appointment-card.completed::before {
    content: '✓';
    position: absolute;
    top: 12px;
    left: 12px;
    font-size: 1.2rem;
    color: #28a745;
    font-weight: bold;
}
</style>
