<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/2/4
 * Time: 3:35 PM
 */
namespace App\Services;
use App\Models\Brand;

class BrandService{
    /**
     * 品牌列表
     * @param int $limit
     * @param $sort
     * @return mixed
     */
    public function brandList($limit=15,$order='desc',$sort='add_time'){
        return Brand::sort($sort,$order)->paginate($limit);
    }
    /**
     * 品牌信息
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function brandDetail($id){
        return Brand::where('id',$id)->first();
    }
}