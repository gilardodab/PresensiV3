<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $primaryKey = 'building_id';

    protected $fillable = [
        'code',
        'name',
        'address',
        'latitude_longtitude',
        'radius'
    ];
    public function employee()
    {
        return $this->hasMany(Employee::class, 'building_id');
    }
}

