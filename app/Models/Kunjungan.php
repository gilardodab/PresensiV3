<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;
    protected $table = 'kunjungan';

    protected $primaryKey = 'kunjungan_id';

    protected $fillable = [
        'employees_id',
        'kunjungan_tgl',
        'time_in',
        'picture_in',
        'status_kunjungan',
        'latitude_longtitude_in',
        'information',
        'callplan',
        'description',
    ];

    // Relasi dengan model Employee
    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employees_id');
    }
}
