<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'brand_name',
        'contact_person',
        'email',
        'whatsapp',
        'social_link',
        'category',
        'photo_link',
        'description',
        'booth_size',
        'special_req',
        'status'
    ];
}