<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'lop_hoc', 'gio_hoc', 'khai_giang', 'ngay_hoc', 'so_buoi', 'co_so', 'hoc_phi', 'schedule_category_id', 'order', 'publish', 'user_id', 'created_at', 'updated_at'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function catalogues()
    {
        return $this->hasOne(ScheduleCategory::class, 'id', 'schedule_category_id');
    }
}
