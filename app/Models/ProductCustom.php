<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCustom extends Model
{
    use HasFactory;
    protected $fillable = [
        'so_dang_ky',
        'product_code',
        'hoat_chat',
        'ham_luong',
        'hang_san_xuat',
        'nuoc_san_xuat',
        'quy_cach_dong_goi',
        'duong_dung',
        'created_at',
        'updated_at',
    ];
}
