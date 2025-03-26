@foreach ($appointments as $appointment)
    <div class="appointment-card">
        <div class="appointment-left">
		<i class="fas fa-calendar-alt"></i>
            <div class="appointment-date">
                {{ \Carbon\Carbon::parse($appointment->booking_date)->format('D, M j Y') }}
            </div>
            <div class="appointment-time">
                {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
            </div>
        </div>

        <div class="appointment-right">
            <div class="trainer-name">
                {{ $appointment->employee->emp_first_name ?? 'No' }}
                {{ $appointment->employee->emp_surname ?? 'Trainer' }}
            </div>
            <div class="trainer-role">Physiotherapist</div>

            <div class="action-buttons">
                <a href="#" class="btn-view">View</a>
                <a href="#" class="btn-cancel">Cancel</a>
            </div>
        </div>
    </div>
@endforeach

<style>
.appointment-card {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    background: #f9f9f9;
    padding: 16px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.appointment-left {
    flex: 1;
    font-weight: bold;
    font-size: 1rem;
    color: #333;
}

.appointment-date {
    font-size: 0.95rem;
    color: #555;
}

.appointment-time {
    font-size: 1.25rem;
    color: #C96E04;
    font-weight: bold;
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
    text-decoration: none;
}

.btn-cancel {
    background: white;
    border: 2px solid #E63946;
    color: #E63946;
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: bold;
    text-decoration: none;
}

</style>
