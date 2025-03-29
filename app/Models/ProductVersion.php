<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVersion extends Model
{
    protected $fillable = [
        'product_id',
        'id_version',
        'title_version',
        'code_version',
        'image_version',
        'price_version',
        'price_sale_version',
        'price_import_version',
        '_stock_status',
        '_stock',
        '_outstock_status',
        '_ships_weight',
        '_ships_length',
        '_ships_width',
        '_ships_height',
        'userid_created',
        'created_at',
        'updated_at'
    ];
    use HasFactory;
    public function product_stocks()
    {
        return $this->hasMany(ProductStock::class, 'product_version_id');
    }
}
