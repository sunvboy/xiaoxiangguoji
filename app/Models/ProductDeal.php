<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDeal extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->select('id', 'title');
    }
    public function product_deal_items()
    {
        return $this->hasMany(ProductDealItem::class, 'product_deal_id')
            ->join('products', 'products.id', '=', 'product_deal_items.product_id')
            ->select('product_deal_items.*', 'products.title', 'products.image');
    }
    use HasFactory;
}
