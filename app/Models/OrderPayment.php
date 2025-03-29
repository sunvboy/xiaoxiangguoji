<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;
    protected $table = 'orders_payment';
    public function getOrder()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}
