<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'note', 'user_id', 'deal_id', 'created_at', 'updated_at',
    ];
}
