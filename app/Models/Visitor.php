<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'whatsapp',
        'instagram',
        'subscribe_newsletter'
    ];
}
