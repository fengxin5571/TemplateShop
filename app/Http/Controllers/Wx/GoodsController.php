<?php

namespace App\Http\Controllers\Wx;

use App\Events\FootPrint;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Pageing;
use App\Services\CategoryService;
use App\Services\GoodsService;
use App\Services\UserService;
use Illuminate\Http\Request;

class GoodsController extends CommonController
{
    protected $services=[];
    public function __construct()
    {
        $this->services['goods']=app()->make(GoodsService::class);
        $this->services['category']=app()->make(CategoryService::class);
        $this->services['user']=app()->make(UserService::class);
    }
    /**
     * 统计商品总数
     * @return \Illuminate\Http\JsonResponse
     */
    public function count(){
        $goodsCount=$this->services['goods']->queryOnSale();
        return $this->success($goodsCount);
    }
    /**
     * 商品分类类目
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function category(Request $request){
        $id=$request->input('id');
        $category=$this->services['category']->findById($id);
        if($category->pid==0){
            $parent=$category;
            $children=$this->services['category']->findByPid($category->id);
        }else{
            $parent=$this->services['category']->findById($category->pid);
            $children=$this->services['category']->findByPid($category->pid);
        }
        return $this->success([
            'currentCategory'=>$category,
            'parentCategory'=>$parent,
            'brotherCategory'=>$children
        ]);
    }
    /**
     * 商品列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $categoryId=$request->input('categoryId');
        $limit=$request->input('limit',10);
        $order=$request->input('order','desc');
        $sort= $request->input('sort','add_time');
        $brandId=$request->input('brandId');
        $keyword=$request->input('keyword');
        $isHot=$request->input('isHot');
        $isNew=$request->input('isNew');
        $goods_list=$this->services['goods']->querySelective($categoryId, $brandId, $keyword, $isHot, $isNew, $limit, $sort, $order);
        $data=new Pageing($goods_list);
        return $this->success($data);
    }
    /**
     * 商品详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail(Request $request){
        $info=$this->services['goods']->findById($request->input('id'));
        //商品规格
        $specificationList=$this->services['goods']->spec($info);
        //商品属性
        $goodsAttributeList=$this->services['goods']->attribute($info);
        //商品问题
        $issue=new Pageing($this->services['goods']->issue('',4));
        //商品货品
        $productListCallable=$this->services['goods']->product($info);
        //用户收藏
        $userHasCollect=$this->services['user']->collect(auth()->guard('wx')->user(),$info->id);
        //浏览足迹
        event(new FootPrint(auth()->guard('wx')->user()->id,$info->id));
        return $this->success([
            'info'=>$info,
            'specificationList'=>$specificationList,
            'productList'=>$productListCallable,
            'attribute'  =>$goodsAttributeList,
            'issue'      =>$issue,
            'userHasCollect'=>$userHasCollect,
        ]);

    }

}
