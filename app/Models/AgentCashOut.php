<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentCashOut extends Model
{
    use HasFactory;
    protected $table = 'agent_cash_out';
    protected $fillable = [
        'amount',
        'method',
        'user_id',
        'status',
    ];
}
