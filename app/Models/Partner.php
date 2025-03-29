<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'image', 'created_at', 'updated_at', 'link', 'user_id', 'order'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
