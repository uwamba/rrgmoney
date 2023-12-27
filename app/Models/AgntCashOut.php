<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentCashOut extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'method',
        'user_id',
        'status',
    ];
}
