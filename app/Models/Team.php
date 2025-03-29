<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'job', 'image', 'user_id', 'created_at', 'updated_at', 'order', 'dao_tao', 'the_manh'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
