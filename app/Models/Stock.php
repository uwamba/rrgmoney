<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'amount_deposit',
        'sequence_number',
        'given_amount',
        'currency',
        'admin_id',
        'user_id',
        'status',
        'reference',
        'balance_before',
        'balance_after',
    ];
}
