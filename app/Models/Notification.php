<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Notification
 * @package App\Models
 * @version March 9, 2025, 7:06 pm UTC
 *
 * @property string $type
 * @property string $notifiable_type
 * @property integer $notifiable_id
 * @property string $data
 * @property string|\Carbon\Carbon $read_at
 */
class Notification extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'notifications';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'type' => 'string',
        'notifiable_type' => 'string',
        'notifiable_id' => 'integer',
        'data' => 'string',
        'read_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'type' => 'required|string|max:255',
        'notifiable_type' => 'required|string|max:255',
        'notifiable_id' => 'required|integer',
        'data' => 'required|string',
        'read_at' => 'nullable',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
