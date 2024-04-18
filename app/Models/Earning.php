<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'currency',
        'sequence_number',
        'entry_type',
        'description',
        'user_id',
        'balance_before',
        'balance_after',
    ];

}
