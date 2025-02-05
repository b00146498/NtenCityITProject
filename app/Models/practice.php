<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class practice
 * @package App\Models
 * @version February 5, 2025, 10:16 pm UTC
 *
 * @property string $company_name
 * @property string $company_type
 * @property string $street
 * @property string $city
 * @property string $county
 * @property string $iban
 * @property string $bic
 */
class practice extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'practice';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'company_name',
        'company_type',
        'street',
        'city',
        'county',
        'iban',
        'bic'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_name' => 'string',
        'company_type' => 'string',
        'street' => 'string',
        'city' => 'string',
        'county' => 'string',
        'iban' => 'string',
        'bic' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'company_name' => 'required|string|max:255',
        'company_type' => 'required|string|max:255',
        'street' => 'required|string|max:255',
        'city' => 'required|string|max:50',
        'county' => 'required|string|max:50',
        'iban' => 'required|string|max:255',
        'bic' => 'required|string|max:255'
    ];

    
}
