<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'catalogue_id', 'catalogue', 'image', 'content', 'description', 'meta_title', 'meta_description', 'userid_created', 'userid_updated', 'created_at', 'updated_at', 'publish', 'order', 'alanguage', 'products'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function relationships()
    {
        return $this->hasMany(Catalogues_relationships::class, 'moduleid');
    }
    public function catalogues()
    {
        return $this->hasOne(CategoryArticle::class, 'id', 'catalogue_id');
    }
    public function tags()
    {
        return $this->hasMany(Tags_relationship::class, 'module_id', 'id')->where('module', '=', 'articles');
    }
    public function getTags()
    {
        return $this->hasMany(Tags_relationship::class, 'module_id', 'id')->where('tags_relationships.module', '=', 'articles')->join('tags', 'tags.id', '=', 'tags_relationships.tag_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'module_id', 'id')->where('module', '=', 'articles')->where('parentid', 0)->get();
    }
}
