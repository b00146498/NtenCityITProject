<div class="appointment-cards">
    @forelse($appointments as $appointment)
       <div class="appointment-card">
    <div class="time">{{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}</div>
    <div class="details">
        <strong>
            {{ $appointment->employee->emp_first_name ?? 'No' }} {{ $appointment->employee->emp_surname ?? 'Trainer' }}
        </strong><br>
        <small>{{ $appointment->employee->role ?? '' }}</small>
    </div>
    <div class="actions">
        <a href="#" class="btn-view">View</a>
        <a href="#" class="btn-cancel">Cancel</a>
    </div>
</div>

    @empty
        <p>No appointments found.</p>
    @endforelse
</div>

<style>
.appointment-cards {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-top: 15px;
}

.appointment-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #f9f9f9;
    padding: 12px 16px;
    border-radius: 15px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.appointment-time {
    font-weight: bold;
    color: #C96E04;
    font-size: 1.3rem;
    width: 80px;
    text-align: center;
}

.appointment-info {
    flex-grow: 1;
    padding: 0 10px;
    font-size: 0.9rem;
}

.appointment-actions {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.btn-view, .btn-cancel {
    padding: 6px 10px;
    font-size: 0.8rem;
    border-radius: 6px;
    font-weight: bold;
    text-align: center;
    display: inline-block;
    text-decoration: none;
}

.btn-view {
    background: #000;
    color: white;
}

.btn-cancel {
    background: white;
    color: #E63946;
    border: 1.5px solid #E63946;
}
</style>
