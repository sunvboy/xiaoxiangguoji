<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealBrandTmp extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_old', 'brand_id', 'created_at', 'updated_at', 'source_date_start', 'source_date_end', 'date_end', 'type'
    ];
}
