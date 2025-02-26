<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

/**
 * Class Client
 * @package App\Models
 * @version February 5, 2025, 10:15 pm UTC
 *
 * @property string $first_name
 * @property string $surname
 * @property string $date_of_birth
 * @property string $gender
 * @property string $email
 * @property string $contact_number
 * @property string $street
 * @property string $city
 * @property string $county
 * @property string $username
 * @property string $password
 * @property string $account_status
 * @property integer $practice_id
 */
class Client extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'client';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $dates = ['deleted_at'];
    public $timestamps = true;

    protected $fillable = [
        'first_name',
        'surname',
        'date_of_birth',
        'gender',
        'email',
        'contact_number',
        'street',
        'city',
        'county',
        'username',
        'password',
        'account_status',
        'practice_id',
        'userid'
    ];

    protected $casts = [
        'id' => 'integer',
        'first_name' => 'string',
        'surname' => 'string',
        'date_of_birth' => 'date',
        'gender' => 'string',
        'email' => 'string',
        'contact_number' => 'string',
        'street' => 'string',
        'city' => 'string',
        'county' => 'string',
        'username' => 'string',
        'password' => 'string',
        'account_status' => 'string',
        'practice_id' => 'integer',
        'userid' => 'string'
    ];

    public static $rules = [
        'first_name' => 'required|string|max:50',
        'surname' => 'required|string|max:50',
        'date_of_birth' => 'required',
        'gender' => 'required|string',
        'email' => 'required|string|max:255',
        'contact_number' => 'required|string|max:15',
        'street' => 'required|string|max:255',
        'city' => 'required|string|max:50',
        'county' => 'required|string|max:50',
        'username' => 'required|string|max:50',
        'password' => 'required|string|max:255',
        'account_status' => 'required|string',
        'practice_id' => 'required|integer',
        'uuserid' => 'required|string|exists:users,id'
    ];

    /**
     * Relationship: A client belongs to a practice.
     */
    public function practice()
    {
        return $this->belongsTo(Practice::class, 'practice_id', 'id');
    }


    /**
     * This function ensures the dropdowns display "First Name Last Name" instead of just IDs.
     */
    public function __toString()
    {
        return $this->first_name . ' ' . $this->surname;
    }
    public function diaryEntries()
    {
        return $this->hasMany(DiaryEntry::class, 'client_id');
    }
    public function user()
    {
        return $this->belongsTo(\App\User::class,'userid','id');
    }

}
