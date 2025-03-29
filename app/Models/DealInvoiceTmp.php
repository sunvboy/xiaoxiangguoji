<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealInvoiceTmp extends Model
{
    use HasFactory;
    protected $fillable = [
        'price', 'price_tax', 'total', 'created_at', 'updated_at', 'deal_invoice_id'
    ];
}
