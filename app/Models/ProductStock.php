<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'product_id',
        'product_version_id',
        'address_id',
        'price',
        'value',
        'stockOrder',
        'stockDeal',
        'stockComing',
        'user_id',
        'created_at',
        'updated_at',

    ];
    public function product_versions()
    {
        return $this->hasOne(ProductVersion::class, 'id', 'product_version_id');
    }
}
