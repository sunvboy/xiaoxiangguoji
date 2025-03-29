<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStockHistory extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
    public function product_versions()
    {
        return $this->hasOne(ProductVersion::class, 'id', 'product_version_id');
    }
}
