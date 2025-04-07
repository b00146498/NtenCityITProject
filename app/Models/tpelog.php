<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class tpelog
 * @package App\Models
 * @version March 10, 2025, 2:25 pm UTC
 *
 * @property integer $plan_id
 * @property integer $exercise_id
 * @property integer $num_sets
 * @property integer $num_reps
 * @property integer $minutes
 * @property string $intensity
 * @property number $incline
 * @property integer $times_per_week
 */
class tpelog extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'tpelog';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'plan_id',
        'exercise_id',
        'num_sets',
        'num_reps',
        'minutes',
        'intensity',
        'incline',
        'times_per_week',
        'completed'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'plan_id' => 'integer',
        'exercise_id' => 'integer',
        'num_sets' => 'integer',
        'num_reps' => 'integer',
        'minutes' => 'integer',
        'intensity' => 'string',
        'incline' => 'decimal:2',
        'times_per_week' => 'integer',
        'completed' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'plan_id' => 'nullable|integer',
        'exercise_id' => 'nullable|integer',
        'num_sets' => 'nullable|integer',
        'num_reps' => 'nullable|integer',
        'minutes' => 'nullable|integer',
        'intensity' => 'nullable|string|max:50',
        'incline' => 'nullable|numeric',
        'times_per_week' => 'nullable|integer',
        'completed' => 'nullable|boolean',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    public function exercise()
    {
        return $this->belongsTo(standardexercises::class, 'exercise_id');
    }

    public function trainingPlan()
    {
        return $this->belongsTo(PersonalisedTrainingPlan::class, 'plan_id');
    }
    public function standardExercise() {
        return $this->belongsTo(StandardExercises::class, 'exercise_id');
    }
}
