<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class safe_pay extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount_foregn_currency',
        'amount_local_currency',
        'currency',
        'reception_method',
        'names',
        'passport',
        'phone',
        'email',
        'address1',
        'address2',
        'user_id',
        'sender_id',
        'receiver_id',
        'status',
        'reference',
        'balance_before',
        'balance_after',
        'passcode',
        'charges' ,
        'reason',
        'details',
        'attachement',
    ];
}
