<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealInvoiceRelationships extends Model
{
    use HasFactory;
    protected $fillable = [
        'created_at', 'updated_at', 'deal_invoice_id', 'user_id', 'title', 'phan_loai', 'duy_tri', 'price', 'quantity', 'tax', 'tax_price', 'total'
    ];
}
