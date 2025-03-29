<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'alanguage', 'title', 'slug', 'image', 'banner', 'parentid',  'order', 'publish', 'ishome', 'highlight', 'isaside', 'isfooter', 'lft', 'rgt', 'level', 'description', 'meta_title', 'meta_description', 'meta_keyword', 'user_id', 'created_at', 'updated_at'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function fields()
    {
        return $this->hasMany(ConfigPostmeta::class, 'module_id')->where(['module' => 'schedule_categories']);
    }
}
