<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributes_relationships extends Model
{
    use HasFactory;
    public function attributes()
    {
        return $this->hasOne(Attribute::class, 'id', 'attribute_id')
            ->select('attributes.id', 'attributes.title', 'category_attributes.title as titleC', 'category_attributes.slug as slugC')
            ->join('category_attributes', 'category_attributes.id', '=', 'attributes.catalogueid')
            ->where('category_attributes.ishome', 0)->orderBy('attributes.order', 'asc')->orderBy('attributes.id', 'desc');
    }
}
