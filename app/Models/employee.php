<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * Class employee
 * @package App\Models
 * @version February 5, 2025, 10:15 pm UTC
 *
 * @property string $emp_first_name
 * @property string $emp_surname
 * @property string $date_of_birth
 * @property string $gender
 * @property string $contact_number
 * @property string $emergency_contact
 * @property string $email
 * @property string $street
 * @property string $city
 * @property string $county
 * @property string $pps_number
 * @property string $role
 * @property string $iban
 * @property string $bic
 * @property string $username
 * @property string $password
 * @property integer $practice_id
 */
class employee extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'employee';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'emp_first_name',
        'emp_surname',
        'date_of_birth',
        'gender',
        'contact_number',
        'emergency_contact',
        'email',
        'street',
        'city',
        'county',
        'pps_number',
        'role',
        'iban',
        'bic',
        'username',
        'password',
        'practice_id',
        'userid',
        'profile_picture'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'emp_first_name' => 'string',
        'emp_surname' => 'string',
        'date_of_birth' => 'date',
        'gender' => 'string',
        'contact_number' => 'string',
        'emergency_contact' => 'string',
        'email' => 'string',
        'street' => 'string',
        'city' => 'string',
        'county' => 'string',
        'pps_number' => 'string',
        'role' => 'string',
        'iban' => 'string',
        'bic' => 'string',
        'username' => 'string',
        'password' => 'string',
        'practice_id' => 'integer',
        'userid' => 'integer',
        'profile_picture' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'emp_first_name' => 'required|string|max:50',
        'emp_surname' => 'required|string|max:50',
        'date_of_birth' => 'required',
        'gender' => 'required|string',
        'contact_number' => 'required|string|max:15',
        'emergency_contact' => 'required|string|max:50',
        'email' => 'required|string|max:255',
        'street' => 'required|string|max:255',
        'city' => 'required|string|max:50',
        'county' => 'required|string|max:50',
        'pps_number' => 'required|string|max:15',
        'role' => 'required|string|max:50',
        'iban' => 'required|string|max:255',
        'bic' => 'required|string|max:255',
        'username' => 'required|string|max:50',
        'password' => 'required|string|max:255',
        'practice_id' => 'required|integer',
        'userid' => 'nullable'
    ];

    public function diaryEntries()
    {
        return $this->hasMany(DiaryEntry::class, 'employee_id');
    }

    public function practice()
    {
        return $this->belongsTo(Practice::class, 'practice_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'userid', 'id');
    }
}