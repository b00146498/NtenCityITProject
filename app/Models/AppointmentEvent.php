<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model as Model;
class AppointmentEvent extends Model
{
    public $table = 'appointmentevent';
    public $timestamps = false;
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'start' => 'string',
        'end' => 'string'
        
    ];
}