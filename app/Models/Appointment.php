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
 * @property time $start_time
 * @property time $end_time
 * @property string $status
 * @property string $notes
 */
class Appointment extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'appointments';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
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
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'client_id' => 'integer',
        'employee_id' => 'integer',
        'practice_id' => 'integer',
        'booking_date' => 'date',
        'status' => 'string',
        'notes' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'client_id' => 'required|integer',
        'employee_id' => 'required|integer',
        'practice_id' => 'required|integer',
        'booking_date' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'status' => 'nullable|string',
        'notes' => 'nullable|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function employee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function practice()
    {
        return $this->belongsTo(\App\Models\Practice::class, 'practice_id');
    }
}
