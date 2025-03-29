<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'image', 'date', 'nganh_nghe', 'so_luong', 'noi_lam_viec', 'muc_luong', 'hinh_thuc_lam_viec', 'so_nam_kinh_nghiem', 'ishome', 'user_id', 'created_at', 'updated_at', 'meta_title', 'meta_description', 'content'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
