<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaryEntry extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'client_id', 'entry_date', 'content'];

    // Each diary entry belongs to ONE employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // Each diary entry belongs to ONE client
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}

