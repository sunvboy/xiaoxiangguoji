<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'iframe', 'link', 'image_json', 'userid_created', 'userid_updated', 'created_at', 'updated_at', 'publish', 'active', 'order', 'long', 'lat', 'image', 'email', 'hotline', 'address', 'cityid', 'districtid', 'wardid', 'time'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function city_name()
    {
        return $this->hasOne(VNCity::class, 'id', 'cityid');
    }
    public function district_name()
    {
        return $this->hasOne(VNDistrict::class, 'id', 'districtid');
    }
    public function ward_name()
    {
        return $this->hasOne(VNWard::class, 'id', 'wardid');
    }
    public function stocks()
    {
        return $this->hasOne(ProductStock::class, 'address_id');
    }
}
