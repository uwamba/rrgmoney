<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class flate_rate extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_amount',
        'to_amount',
        'charges_amount',
        'charges_amount_percentage',
        'charges_amount_cashout',
        'charges_amount_percentage_cashout', 
        'currency_id',

    ];

}
