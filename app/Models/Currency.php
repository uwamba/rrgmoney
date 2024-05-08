<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'currency_name',
        'currency_buying_rate',
        'currency_selling_rate',
        'currency_reference',
        'currency_country',
        'pricing_plan',
        'charges_percentage',
    ];

}
