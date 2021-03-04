<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/2/8
 * Time: 12:26 PM
 */
namespace App\Http\Controllers\Wx;
use App\Http\Controllers\CommonController;
use App\Models\SearchHistory;
use App\Services\UserService;
use Illuminate\Http\Request;

class OtherController extends CommonController{
    protected $services=[];
    public function __construct()
    {
        $this->services['user']=app()->make(UserService::class);
    }
    /**
     * 添加删除收藏
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addordelete(Request $request){
        $this->services['user']->addordelete(auth()->guard('wx')->user(),$request->input('valueId'));
        return $this->success('');
    }
    /**
     * 用户搜索记录
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(){
        $data=$this->services['user']->history(auth()->guard('wx')->user()->id);
        return $this->success($data);
    }
}