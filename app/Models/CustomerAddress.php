<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'address',
        'city_id',
        'district_id',
        'ward_id',
        'customer_id',
        'publish',
        'created_at',
        'updated_at',
    ];
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
