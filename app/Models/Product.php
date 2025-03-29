<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage',
        'title',
        'slug',
        'catalogue_id',
        'image',
        'image_json',
        'description',
        'content',
        'code',
        'price',
        'price_sale',
        'price_contact',
        'price_import',
        'catalogue',
        'version_json',
        'meta_title',
        'meta_description',
        'order',
        'publish',
        'ishome',
        'highlight',
        'inventory',
        'inventoryPolicy',
        'inventoryQuantity',
        'created_at',
        'updated_at',
        'userid_created',
        'userid_updated',
        'brand_id',
        'ships',
        'unit',
        'type',
        'so_dang_ky',
        'hoat_chat',
        'ham_luong',
        'nuoc_san_xuat',
        'quy_cach_dong_goi',
        'duong_dung',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function relationships()
    {
        return $this->hasMany(Catalogues_relationships::class, 'moduleid');
    }
    public function detailCategoryProduct()
    {
        return $this->hasOne(CategoryProduct::class, 'id', 'catalogue_id');
    }
    public function tags()
    {
        return $this->hasMany(Tags_relationship::class, 'module_id')->select('tag_id', 'module_id')->where('module', '=', 'products');
    }
    public function getTags()
    {
        return $this->hasMany(Tags_relationship::class, 'module_id', 'id')->select('tag_id', 'module_id', 'tags.title', 'tags.slug')->where('tags_relationships.module', '=', 'products')->join('tags', 'tags.id', '=', 'tags_relationships.tag_id');
    }
    public function brands()
    {
        return $this->hasMany(Brands_relationships::class, 'product_id');
    }
    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'module_id');
    }
    public function field()
    {
        return $this->hasOne(ConfigPostmeta::class, 'module_id')->where(['module' => 'products']);
    }
    public function fields()
    {
        return $this->hasMany(ConfigPostmeta::class, 'module_id')->where(['module' => 'products']);
    }
    public function product_versions()
    {
        return $this->hasMany(ProductVersion::class, 'product_id');
    }
    public function TaxesRelationships()
    {
        return $this->hasOne(TaxesRelationships::class, 'product_id');
    }
    public function product_stocks()
    {
        return $this->hasMany(ProductStock::class, 'product_id')->orderBy('id', 'desc');
    }
    public function product_stock_histories()
    {
        return $this->hasMany(ProductStockHistory::class, 'product_id')->orderBy('id', 'desc');
    }
    public function deals()
    {
        return $this->hasManyThrough(ProductDealItem::class, ProductDeal::class);
    }
}
