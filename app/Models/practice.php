<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Practice
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
class Practice extends Model
{
    use HasFactory, SoftDeletes; // Corrected trait order

    protected $table = 'practice'; // Explicitly define the table name

    protected $dates = ['deleted_at']; // Ensure SoftDeletes works correctly

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
     * The attributes that should be cast to native types.
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
     * Validation rules.
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
