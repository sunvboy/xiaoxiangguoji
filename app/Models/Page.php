<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'image', 'page', 'description', 'content',  'video', 'banner', 'meta_title', 'meta_description', 'userid_created', 'userid_updated', 'created_at', 'updated_at', 'publish', 'alanguage'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function field()
    {
        return $this->hasOne(ConfigPostmeta::class, 'module_id')->where(['module' => 'pages'])->select('module_id', 'meta_key', 'meta_value');
    }
    public function fields()
    {
        return $this->hasMany(ConfigPostmeta::class, 'module_id')->where(['module' => 'pages'])->select('module_id', 'meta_key', 'meta_value');
    }
}
