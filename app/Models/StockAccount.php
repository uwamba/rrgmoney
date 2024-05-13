<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockAccount extends Model
{
    use HasFactory;
    public function accountBalance(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    protected $fillable = [
        'name',
        'description',
        'currency',
        'created_by',
        'modified_by',
    ];
}
