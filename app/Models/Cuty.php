<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuty extends Model
{
    use HasFactory;
    protected $table = 'cuty';
    protected $primaryKey = 'cuty_id';

    protected $fillable = [
        'employees_id',
        'cuty_start',
        'cuty_end',
        'date_work',
        'cuty_total',
        'cuty_description',
        'cuty_status'
    ];

    // Relationships
    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employees_id');
    }

    public function employeess()
{
    return $this->belongsTo(Employee::class, 'employees_id', 'id'); // pastikan nama foreign key dan primary key benar
}

    public function position(){
        return $this->belongsTo(Position::class, 'position_id');
    }
}
