<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/2/2
 * Time: 9:05 AM
 */
namespace App\Services;

use App\Model\User;
use Illuminate\Support\Facades\Auth;

class AddressService{
    protected $user;
    protected $guarded=[];
    public function __construct()
    {
        $this->user=Auth::guard('wx')->user();
    }
    /**
     * 用户地址
     * @param int $limit
     * @return mixed
     */
    public function queryUserAddresses($limit=15){
        return $this->user->addresses()->paginate($limit);
    }
    public function delete($address_id){
        return $this->user->addresses()->find($address_id)->delete();
    }
    public function save($data){
        return $this->user->addresses()->create($data);
    }
}