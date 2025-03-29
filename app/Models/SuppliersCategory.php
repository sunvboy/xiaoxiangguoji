<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliersCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'code', 'description', 'userid_created', 'publish', 'order', 'created_at', 'updated_at'
    ];
    public function counts()
    {
        return $this->hasMany(Suppliers::class, 'category_id', 'id');
    }
}
