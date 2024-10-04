<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;
    protected $table = 'maintenance';

    protected $fillable = [
        'employees_id',
        'id_customers',
        'kalibrasi_awal',
        'noseri_mt',
        'tgl_mt',
        'jam_mt',
        'ket_mt',
        'kalibrasi_mt',
        'lokasi_mt',
    ];
}
