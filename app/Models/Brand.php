<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $name 品牌商名称
 * @property string $desc 品牌商简介
 * @property string $pic_url 品牌商页的品牌商图片
 * @property int|null $sort_order
 * @property string|null $floor_price 品牌商的商品低价，仅用于页面展示
 * @property \Illuminate\Support\Carbon|null $add_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 更新时间
 * @property int|null $deleted 逻辑删除
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereAddTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereFloorPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand wherePicUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereSortOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereUpdateTime($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Brand sort($sort = 'add_time', $order = 'desc')
 */
class Brand extends Model
{
    use HasFactory;
    protected $table='brand';
    const CREATED_AT = 'add_time';
    const UPDATED_AT = 'update_time';
    protected $guarded=[];
    protected function serializeDate(\DateTimeInterface $date) : string
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function scopeSort($query,$sort='add_time',$order='desc'){
        return $query->orderBy($sort,$order);
    }
}
