<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturers extends Model
{
    use HasFactory;
    protected $fillable = ['sex', 'name', 'image', 'ishome', 'experience', 'description', 'job', 'user_id', 'created_at', 'updated_at', 'order'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
