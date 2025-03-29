<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'code',
        'category_id',
        'phone',
        'email',
        'label',
        'address',
        'city_id',
        'district_id',
        'ward_id',
        'fax',
        'taxNumber',
        'website',
        'debt',
        'user_id',
        'description',
        'payment',
        'userid_created',
        'created_at',
        'updated_at',
    ];
    public function categories()
    {
        return $this->hasOne(SuppliersCategory::class, 'id', 'category_id')->select('id', 'title');
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
}
