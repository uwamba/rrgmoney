<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Send extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount_foregn_currency',
        'amount_local_currency',
        'currency',
        'class',
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
        'balance_after_temp',
        'passcode',
        'charges' ,
    ];

}
