<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Appointment
 * @package App\Models
 * @version February 22, 2025, 7:13 am UTC
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

    protected $dates = ['deleted_at'];

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
     *
     * @var array
     */
    protected $casts = [
        'id'          => 'integer',
        'client_id'   => 'integer',
        'employee_id' => 'integer',
        'practice_id' => 'integer',
        'booking_date'=> 'date',
        'start_time'  => 'string', // Time should be handled in Carbon for formatting
        'end_time'    => 'string',
        'status'      => 'string',
        'notes'       => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'client_id'   => 'required|integer',
        'employee_id' => 'required|integer',
        'practice_id' => 'required|integer',
        'booking_date'=> 'required|date',
        'start_time'  => 'required',
        'end_time'    => 'required',
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
        return date('h:i A', strtotime($this->start_time)) . ' - ' . date('h:i A', strtotime($this->end_time));
    }

    /**
     * Get status color for FullCalendar integration
     */
    public function getStatusColor()
    {
        return match ($this->status) {
            'confirmed'  => 'green',
            'pending'    => 'yellow',
            'checked-in' => 'blue',
            'completed'  => 'gray',
            'canceled'   => 'red',
            default      => 'black',
        };
    }
}
