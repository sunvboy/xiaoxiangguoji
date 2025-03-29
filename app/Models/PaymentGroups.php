<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGroups extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'code', 'description', 'checked', 'userid_created',  'created_at', 'updated_at'
    ];
}
