<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchasesItem extends Model
{
    use HasFactory;
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->select('products.id', 'products.title', 'products.image', 'products.unit');
    }
    public function product_version()
    {
        return $this->hasOne(ProductVersion::class, 'id_version', 'product_version')->select('product_versions.id_version', 'product_versions.title_version');
    }
}
