<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'company_name',
        'contact_person',
        'email',
        'whatsapp',
        'social_link',
        'interest',
        'idea',
        'budget',
        'deck_link',
        'status'
    ];
}