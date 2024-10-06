<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
        // Tentukan nama tabel
        protected $table = 'settings';

        // Kolom yang dapat diisi (mass assignable)
        protected $fillable = [
            'site_url',
            'site_name',
            'site_company',
            'site_manager',
            'site_director',
            'site_phone',
            'site_address',
            'site_description',
            'site_logo',
            'site_email',
            'site_email_domain',
        ];
}
