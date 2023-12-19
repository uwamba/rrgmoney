<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUpsSends extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'topup_id',
        'sends_id',
    ];

}
