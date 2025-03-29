<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;
    protected $fillable = [
        'ips', 'suspend', 'products', 'free', 'catalogue_id', 'brand_id', 'tag_id', 'catalogue_child_id', 'id_old', 'price_1', 'price_2', 'price_3', 'price_4', 'price_5', 'title', 'status', 'price', 'price_collected', 'price_not_collected', 'date_end', 'type', 'source', 'source_description', 'source_date_start', 'source_date_end', 'users_support', 'users_join', 'domain', 'file', 'parent_id', 'customer_id', 'userid_created', 'userid_updated', 'created_at', 'updated_at', 'website', 'email', 'phone', 'address', 'company', 'note'
    ];
    public function user_created()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function user_updated()
    {
        return $this->hasOne(User::class, 'id', 'userid_updated');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
    public function category_products()
    {
        return $this->hasOne(CategoryProduct::class, 'id', 'catalogue_id');
    }
    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
    public function deal_relationships()
    {
        return $this->hasMany(DealRelationships::class, 'deal_id', 'id');
    }
    public function deal_invoices()
    {
        return $this->hasMany(DealInvoice::class, 'deal_id', 'id');
    }
    public function deal_histories()
    {
        return $this->hasMany(DealHistory::class, 'deal_id', 'id')->orderBy('id', 'desc');
    }
}
