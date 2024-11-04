<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Callplan extends Model
{
    use HasFactory;

    protected $table = 'callplan';

    protected $primaryKey = 'callplan_id';

    protected $fillable = [
        'employees_id',
        'tanggal_cp',
        'nama_outlet',
        'description',
    ];

    // Jika ada relasi dengan model Employee, bisa ditambahkan
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employees_id');
    }
}
