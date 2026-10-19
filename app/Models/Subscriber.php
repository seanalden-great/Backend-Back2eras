<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    // Mengizinkan kolom 'email' untuk diisi (mass-assignment)
    protected $fillable = ['email'];
}