<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id', 'total_in','total_out','created_at', 'updated_at'
    ];

    public function drugs()
    {
        return $this->belongsTo(Drug::class, '');
    }
}
