<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealRelationships extends Model
{
    use HasFactory;
    protected $fillable = [
        'catalogue_id', 'domain', 'deal_id', 'title', 'price', 'total', 'quantity', 'unit', 'sales', 'tax', 'tax_price', 'created_at', 'updated_at', 'product_price_sale_type', 'phan_loai', 'duy_tri'
    ];
}
