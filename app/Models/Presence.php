<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;
    protected $table = 'presence';
    protected $primaryKey = 'presence_id';

    protected $fillable = [
        'employees_id',
        'presence_date',
        'time_in',
        'time_out',
        'picture_in',
        'picture_out',
        'present_id',
        'latitude_longtitude_in',
        'latitude_longtitude_out',
        'information'
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employees_id');
    }

    public function building ()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
    public function presentStatus()
    {
        return $this->belongsTo(PresentStatus::class, 'present_id', 'present_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
