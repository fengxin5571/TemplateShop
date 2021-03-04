<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/2/4
 * Time: 3:31 PM
 */
namespace App\Http\Controllers\Wx;
use App\Exceptions\BusinessException;
use App\Http\Controllers\CommonController;
use App\Http\Resources\Pageing;
use App\Services\BrandService;
use Illuminate\Http\Request;

class  BrandController extends CommonController{
    protected $brandService;
    public function __construct()
    {
        $this->brandService=app()->make(BrandService::class);
    }
    /**
     *品牌列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $list=$this->brandService->brandList(
            $request->input('limit',10),
            $request->input('order','desc'),
            $request->input('sort','add_time')
        );
        $data=new Pageing($list);
        return $this->success($data);
    }
    /**
     * 品牌信息
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function detail($id){
        if(empty($id)){
            throw new BusinessException('参数不对',703);
        }
        $data=$this->brandService->brandDetail($id);
        return $this->success($data);
    }
}