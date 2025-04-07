<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

/**
 * Class client
 * @package App\Models
 * @version February 26, 2025, 3:36 pm UTC
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
 * @property integer $userid
 */
class client extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Notifiable;

    public $table = 'client';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
 
    protected $dates = ['deleted_at'];

    public $fillable = [
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
        'userid', 
        'strava_access_token',
        'strava_refresh_token',
        'strava_token_expires_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
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
        'userid' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
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
        'userid' => 'nullable'
    ];
    
    /**
     * Get the user associated with the client.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
    
    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }
    public function practice()
    {
        return $this->belongsTo(Practice::class, 'practice_id');
    }

    public function trainingPlans() {
        return $this->hasMany(PersonalisedTrainingPlan::class, 'client_id');
    }


}