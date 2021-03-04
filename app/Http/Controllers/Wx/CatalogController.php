<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/2/3
 * Time: 10:10 AM
 */
namespace APP\Http\Controllers\Wx;
use App\Http\Controllers\CommonController;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class  CatalogController extends CommonController{
    protected $categoryService;
    public function __construct()
    {
        $this->categoryService=app()->make(CategoryService::class);
    }
    /**
     * 获取分类信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function catalog(Request $request){
        $data['categoryList']=$this->categoryService->getCategory();
        list($data['currentCategory'],$data['currentSubCategory'])=$this->categoryService->currentCategory($request->input('id'));
        return $this->success($data);
    }
}