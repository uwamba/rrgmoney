<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topup extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'currency',
        'charge',
        'payment_type',
        'sequence_number',
        'agent',
        'user_id',
        'status',
        'reference',
        'balance_after_temp',
        'balance_before',
        'balance_after',
    ];


}
