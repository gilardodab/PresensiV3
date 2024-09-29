<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentStatus extends Model
{
    use HasFactory;
    protected $table = 'present_status';
    protected $primaryKey = 'present_id';
    public $timestamps = false;
}
