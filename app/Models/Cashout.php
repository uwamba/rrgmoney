<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cashout extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'method',
        'details',
        'charges',
        'currency',
        'location',
        'receiver_id',
        'transfer_id',
        'user_id',
        'status',
        'admin_message',
        'balance_before',
        'balance_after',
    ];
}
