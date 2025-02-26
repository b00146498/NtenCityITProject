<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class customer
 * @package App\Models
 * @version February 26, 2025, 3:24 pm UTC
 *
 * @property string $firstname
 * @property string $surname
 */
class customer extends Model
{
    //use SoftDeletes;

    use HasFactory;

    public $table = 'customer';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    public $timestamps=false;
    public $softdeletes=false;


    public $fillable = [
        'firstname',
        'surname'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'firstname' => 'string',
        'surname' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'firstname' => 'nullable|string',
        'surname' => 'nullable|string'
    ];

    
}
