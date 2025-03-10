<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class standardexercises
 * @package App\Models
 * @version March 10, 2025, 2:24 pm UTC
 *
 * @property string $exercise_name
 * @property string $exercise_video_link
 * @property string $target_body_area
 */
class standardexercises extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'standardexercises';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'exercise_name',
        'exercise_video_link',
        'target_body_area'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'exercise_name' => 'string',
        'exercise_video_link' => 'string',
        'target_body_area' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'exercise_name' => 'required|string|max:255',
        'exercise_video_link' => 'nullable|string|max:255',
        'target_body_area' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
