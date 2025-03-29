<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVouchers extends Model
{
    use HasFactory;
    protected $fillable = [

        'address_id',
        'code',
        'module',
        'module_id',
        'group_id',
        'price',
        'type',
        'reference',
        'description',
        'checked',
        'userid_created',
        'created_at',
        'updated_at',
    ];
    public function payment_groups()
    {
        return $this->hasOne(PaymentGroups::class, 'id', 'group_id')->select('id', 'title');
    }
    public function product_purchases()
    {
        return $this->hasOne(ProductPurchase::class, 'id', 'module_id')->with('suppliers');
    }
    public function users()
    {
        return $this->hasOne(User::class, 'id', 'module_id')->select('id', 'name');
    }
    public function customers()
    {
        return $this->hasOne(Customer::class, 'id', 'module_id')->select('id', 'name');
    }
}
