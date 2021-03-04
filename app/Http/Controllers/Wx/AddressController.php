<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/2/1
 * Time: 4:21 PM
 */
namespace App\Http\Controllers\Wx;
use App\Exceptions\BusinessException;
use App\Http\Controllers\CommonController;
use App\Http\Requests\AddressSavePost;
use App\Http\Resources\Pageing;
use App\Models\User;
use App\Services\AddressService;
use Illuminate\Http\Request;

class AddressController extends CommonController{
    protected $addressService;
    public function __construct()
    {
        $this->addressService=app()->make(AddressService::class);
    }
    /**
     * 用户地址
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(){
        $list=$this->addressService->queryUserAddresses(10);
        $data=new Pageing($list);
        return $this->success($data);
    }
    public function save(AddressSavePost $addressSavePost){
        $insert_date=[
            'address_detail'=>$addressSavePost->validated()['addressDetail'],
            'name'=>$addressSavePost->validated()['name'],
            'tel'=>$addressSavePost->validated()['tel'],
            'is_default'=>request()->input('isDefault'),
            'area_code'=>request()->input('areaCode'),
            'city'=>request()->input('city'),
            'county'=>request()->input('county'),
            'province'=>request()->input('province'),
            'postal_code'=>request()->input('postalCode'),
        ];
        if(!$this->addressService->save($insert_date)){
            throw  new BusinessException('添加失败',703);
        }
        return $this->success('','添加成功');
    }
}