<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'stock', 'drug_id', 'created_at', 'updated_at'
    ];

    public function drugs()
    {
        return $this->belongsTo(Drug::class, 'drug_id');
    }
}
