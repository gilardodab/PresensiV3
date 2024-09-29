<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//include Building
use App\Models\Building;

class Employee extends Authenticatable
{
    use Notifiable;
    use HasFactory;

    protected $guarded = [];

    // Relationships
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    // Define the relationship with the Shift model
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    // Define the relationship with the Building model
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    protected $hidden = ['employees_password'];  // Hide password when serializing model

    // Specify the custom password field for Auth
    public function getAuthPassword()
    {
        return $this->employees_password;
    }
}
