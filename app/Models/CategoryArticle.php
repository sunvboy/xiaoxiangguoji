<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryArticle extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'parentid', 'description', 'image', 'image_json', 'meta_title', 'meta_description', 'userid_created', 'userid_updated', 'created_at', 'updated_at', 'publish', 'order', 'alanguage', 'banner'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userid_created');
    }
    public function catalogue()
    {
        return $this->hasOne(CategoryArticle::class, 'id', 'catalogue_id');
    }
    public function listArticle()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid')->where('module', '=', 'articles');
    }
    public function articles()
    {
        return $this->hasMany(Article::class, 'catalogue_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(CategoryArticle::class, 'parentid', 'id')->select('id', 'title', 'slug', 'parentid', 'image')->orderBy('order', 'asc')->orderBy('id', 'desc');
    }
    public function posts()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid')->where('module', '=', 'articles')
            ->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
            ->join('category_articles', 'category_articles.id', '=', 'articles.catalogue_id')
            ->where(['articles.publish' => 0])
            ->select('articles.title', 'articles.id', 'articles.slug', 'articles.image', 'articles.viewed', 'articles.description', 'articles.catalogue_id', 'category_articles.title as titleC', 'category_articles.slug as slugC', 'catalogues_relationships.catalogueid', 'articles.created_at')
            ->orderBy('articles.order', 'asc')->orderBy('articles.id', 'desc');
    }
    public function posts5()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid')->where('module', '=', 'articles')
            ->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
            ->join('category_articles', 'category_articles.id', '=', 'articles.catalogue_id')
            ->where(['articles.publish' => 0])
            ->select('articles.title', 'articles.id', 'articles.slug', 'articles.image', 'articles.description', 'articles.catalogue_id', 'category_articles.title as titleC', 'category_articles.slug as slugC', 'catalogues_relationships.catalogueid', 'articles.created_at')
            ->orderBy('articles.order', 'asc')->orderBy('articles.id', 'desc')->limit(5);
    }
    public function posts6()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid')->where('module', '=', 'articles')
            ->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
            ->join('category_articles', 'category_articles.id', '=', 'articles.catalogue_id')
            ->where(['articles.publish' => 0])
            ->select('articles.title', 'articles.id', 'articles.slug', 'articles.image', 'articles.description', 'articles.catalogue_id', 'category_articles.title as titleC', 'category_articles.slug as slugC', 'catalogues_relationships.catalogueid', 'articles.created_at')
            ->orderBy('articles.order', 'asc')->orderBy('articles.id', 'desc')->limit(6);
    }
    public function postsFields()
    {
        return $this->hasMany(Catalogues_relationships::class, 'catalogueid')->where('catalogues_relationships.module', '=', 'articles')
            ->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
            ->join('config_postmetas', 'catalogues_relationships.moduleid', '=', 'config_postmetas.module_id')
            ->where(['articles.publish' => 0, 'config_postmetas.module' => 'articles'])
            ->select('articles.id', 'articles.title', 'articles.slug', 'articles.image', 'catalogues_relationships.catalogueid', 'config_postmetas.meta_value')
            ->orderBy('articles.order', 'asc')->orderBy('articles.id', 'desc');
    }
}
