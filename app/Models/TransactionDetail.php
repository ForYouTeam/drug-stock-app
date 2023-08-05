<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'in','out','request_amount','receive_amount','drug_id','user_id','created_at', 'updated_at'
    ];
}
