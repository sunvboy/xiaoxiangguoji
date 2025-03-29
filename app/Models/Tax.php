<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'code',
        'value',
        'taxSale',
        'taxPurchase',
        'active',
        'created_at',
        'updated_at',
    ];
}
