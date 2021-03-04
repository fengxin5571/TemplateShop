<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SearchHistory
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SearchHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SearchHistory query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id 用户表的用户ID
 * @property string $keyword 搜索关键字
 * @property string $from 搜索来源，如pc、wx、app
 * @property \Illuminate\Support\Carbon|null $add_time 创建时间
 * @property \Illuminate\Support\Carbon|null $update_time 更新时间
 * @property int|null $deleted 逻辑删除
 * @method static \Illuminate\Database\Eloquent\Builder|SearchHistory whereAddTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchHistory whereDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchHistory whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchHistory whereKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchHistory whereUpdateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SearchHistory whereUserId($value)
 */
class SearchHistory extends Model
{
    use HasFactory;
    protected $table='search_history';
    const CREATED_AT = 'add_time';
    const UPDATED_AT = 'update_time';
    protected $guarded=[];
    protected function serializeDate(\DateTimeInterface $date) : string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
