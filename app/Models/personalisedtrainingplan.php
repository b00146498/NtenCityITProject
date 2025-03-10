<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class personalisedtrainingplan
 * @package App\Models
 * @version March 10, 2025, 2:25 pm UTC
 *
 * @property integer $client_id
 * @property string $start_date
 * @property string $end_date
 */
class personalisedtrainingplan extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'personalisedtrainingplan';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'client_id',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'client_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'client_id' => 'nullable|integer',
        'start_date' => 'nullable',
        'end_date' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
