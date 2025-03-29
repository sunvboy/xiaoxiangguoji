<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['status'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customerid');
    }
    public function city_name()
    {
        return $this->hasOne(VNCity::class, 'id', 'city_id');
    }
    public function district_name()
    {
        return $this->hasOne(VNDistrict::class, 'id', 'district_id');
    }
    public function ward_name()
    {
        return $this->hasOne(VNWard::class, 'id', 'ward_id');
    }
    public function order_returns()
    {
        return $this->hasOne(OrderReturn::class, 'order_id', 'id');
    }
}
