<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'user_id', 'created_at', 'updated_at'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
