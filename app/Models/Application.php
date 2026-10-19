<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['brand_name', 'category', 'email', 'details', 'count', 'status'];
}