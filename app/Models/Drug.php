<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\DrugFactory;

class Drug extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','unit','desc', 'created_at', 'updated_at'
    ];

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class, 'drug_id');
    }
}
