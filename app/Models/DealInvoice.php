<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'deleted_at', 'deleted_id', 'catalogue_id', 'title', 'status', 'status_tax', 'status_2', 'payment', 'customer_id', 'deal_id', 'type', 'tax', 'price_tax', 'price', 'total', 'date_end', 'source_date_end', 'note', 'comment', 'user_id', 'created_at', 'updated_at'
    ];
    public function deal()
    {
        return $this->hasOne(Deal::class, 'id', 'deal_id');
    }
    public function category_products()
    {
        return $this->hasOne(CategoryProduct::class, 'id', 'catalogue_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
    public function deal_invoice_relationships()
    {
        return $this->hasMany(DealInvoiceRelationships::class, 'deal_invoice_id', 'id');
    }
}
