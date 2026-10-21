<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    // Tabel otomatis bernama 'media', bukan 'medias' karena Laravel mendeteksi 'media' sebagai plural yang benar.
    protected $fillable = [
        'media_name',
        'contact_person',
        'email',
        'whatsapp',
        'social_links',
        'media_category',
        'audience_size',
        'media_kit',
        'coverage_format',
        'status'
    ];
}