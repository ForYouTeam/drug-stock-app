<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiver_id', 'total_in','total_out','created_at', 'updated_at'
    ];

    public function receiver()
    {
        return $this->belongsTo(Receiver::class);
    }
}
