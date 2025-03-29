<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'suppliers_id',
        'address_id',
        'products',
        'price_vat',
        'price_suppliers',
        'price_refunded',
        'price_total',
        'discount',
        'status',
        'financialStatusValue',
        'financialStatus',
        'financialInfo',
        'receiveStatusValue',
        'receiveStatus',
        'reference',
        'dueOn',
        'note',
        'surcharge',
        'history',
        'user_id',
        'created_at',
        'updated_at',
        'created_stock_at',
        'created_completed_at',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function suppliers()
    {
        return $this->hasOne(Suppliers::class, 'id', 'suppliers_id');
    }
    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
    public function product_purchases_financials()
    {
        return $this->hasMany(ProductPurchasesFinancial::class, 'product_purchases_id')->orderBy('id', 'asc');
    }
    public function product_purchases_returns()
    {
        return $this->hasMany(ProductPurchasesReturns::class, 'product_purchases_id')->orderBy('id', 'asc');
    }
    public function product_purchases_items()
    {
        return $this->hasMany(ProductPurchasesItem::class, 'product_purchases_id')->orderBy('id', 'asc');
    }
}
