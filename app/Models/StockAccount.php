<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'currency',
        'created_by',
        'modified_by',     
    ];
}
