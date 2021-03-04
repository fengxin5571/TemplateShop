<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/2/5
 * Time: 9:51 AM
 */
namespace App\Services;
use App\Events\SearchKeyword;
use App\Models\Goods;
use App\Models\Issue;

class GoodsService{
    protected $goods;
    public function __construct(Goods $goods)
    {
        $this->goods=$goods;
    }
    /**
     * 统计商品总数
     * @return mixed
     */
    public function queryOnSale(){
        return $this->goods->onSale()->count();
    }
    /**
     * 商品列表
     * @param $categoryId
     * @param $brandId
     * @param $keyword
     * @param $isHot
     * @param $isNew
     * @param $limit
     * @param $sort
     * @param $order
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function querySelective($categoryId, $brandId, $keyword, $isHot, $isNew, $limit, $sort, $order){
        $propGoods=$this->goods->onSale()->orderBy($sort,$order);
        if($categoryId) $propGoods->whereCategoryId($categoryId);
        if($brandId) $propGoods->whereBrandId($brandId);
        if($isHot) $propGoods->whereIsHot($isHot);
        if($isNew) $propGoods->whereIsNew($isNew);
        if($keyword) {
            $propGoods->where('name','like',"%{$keyword}%");
            //记录搜索记录
            event(new SearchKeyword($keyword,[
                'user_id'=>auth()->guard('wx')->user()->id,
                'from'=>'wx'
            ]));
        }
        return $propGoods->paginate($limit);
    }
    /**
     * 商品问题
     * @param $question
     * @param $limit
     * @param string $sort
     * @param string $order
     * @return mixed
     */
    public function issue($question, $limit, $sort='add_time',  $order='desc'){
        $propIssue=Issue::orderBy($sort,$order);
        if($question) $propIssue->where('question','like',"%{$question}%");
        return $propIssue->paginate($limit);
    }
    /**
     * 商品信息
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function findById($id){
        $info=$this->goods->onSale()->where('id',$id)->first();
        return $info;
    }
    /**
     * 商品规格
     * @param $goods
     * @return mixed
     */
    public function spec($goods){
        $spec=$goods->spec()->get()->groupBy('specification');
        return $spec->map(function ($v,$k){
            return ['name'=>$k,'valueList'=>$v];
        })->values();
    }
    /**
     * 商品货品
     * @param $goods
     * @return mixed
     */
    public function product($goods){
        return $goods->product()->get();
    }
    /**
     * 商品属性
     * @param $goods
     * @return mixed
     */
    public function attribute($goods){
        return $goods->attribute()->get();
    }
}