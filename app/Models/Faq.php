<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'user_id', 'created_at', 'updated_at', 'order', 'catalogue_id', 'reply', 'name', 'viewed'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function faq_categories()
    {
        return $this->hasOne(FaqCategory::class, 'id', 'catalogue_id');
    }
}
