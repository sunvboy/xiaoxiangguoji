<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchasesFinancial extends Model
{
    use HasFactory;
    protected $fillable = [
        'price',
        'method',
        'reference',
        'product_purchases_id',
        'userid_created',
        'created_at',
        'updated_at',
    ];
    public function users()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
}
