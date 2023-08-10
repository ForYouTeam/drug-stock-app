<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\DrugFactory;

class Drug extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'created_at', 'updated_at'
    ];
}
