<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsProduct extends Model
{
    use HasFactory;
    protected $table='goods_product';
    const CREATED_AT = 'add_time';
    const UPDATED_AT = 'update_time';
    protected $guarded=[];
    protected $casts = [
        'specifications' => 'array',
    ];
    protected function serializeDate(\DateTimeInterface $date) : string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
