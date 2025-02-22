<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

/**
 * Class Appointment
 * @package App\Models
 *
 * @property \App\Models\Client $client
 * @property \App\Models\Employee $employee
 * @property \App\Models\Practice $practice
 * @property integer $client_id
 * @property integer $employee_id
 * @property integer $practice_id
 * @property string $booking_date
 * @property string $start_time
 * @property string $end_time
 * @property string $status
 * @property string|null $notes
 */
class Appointment extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'appointments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at', 'booking_date'];

    protected $fillable = [
        'client_id',
        'employee_id',
        'practice_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'notes'
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'id'          => 'integer',
        'client_id'   => 'integer',
        'employee_id' => 'integer',
        'practice_id' => 'integer',
        'booking_date'=> 'date',
        'start_time'  => 'string',
        'end_time'    => 'string',
        'status'      => 'string',
        'notes'       => 'string',
    ];

    /**
     * Validation rules
     */
    public static $rules = [
        'client_id'   => 'required|exists:clients,id',
        'employee_id' => 'required|exists:employees,id',
        'practice_id' => 'required|exists:practices,id',
        'booking_date'=> 'required|date',
        'start_time'  => 'required|date_format:H:i:s',
        'end_time'    => 'required|date_format:H:i:s|after:start_time',
        'status'      => 'nullable|string',
        'notes'       => 'nullable|string',
    ];

    /**
     * Relationships
     */
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id');
    }

    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }

    public function practice()
    {
        return $this->belongsTo(\App\Models\Practice::class, 'practice_id');
    }

    /**
     * Get formatted appointment time
     */
    public function getFormattedTimeAttribute()
    {
        return Carbon::parse($this->start_time)->format('h:i A') . ' - ' . Carbon::parse($this->end_time)->format('h:i A');
    }

    /**
     * Get status color for FullCalendar integration
     */
    public function getStatusColor()
    {
        return match (strtolower($this->status)) {
            'confirmed'  => 'green',
            'pending'    => 'yellow',
            'checked-in' => 'blue',
            'completed'  => 'gray',
            'canceled'   => 'red',
            default      => 'black',
        };
    }

    /**
     * Mutators to ensure correct input format
     */
    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = Carbon::parse($value)->format('H:i:s');
    }

    public function setEndTimeAttribute($value)
    {
        $this->attributes['end_time'] = Carbon::parse($value)->format('H:i:s');
    }
}
