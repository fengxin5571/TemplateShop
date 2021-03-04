<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/1/29
 * Time: 11:14 AM
 */
namespace App\Services;
use App\Exceptions\BusinessException;
use App\Models\SearchHistory;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserService{
    /**
     * 根据用户名查找用户
     * @param $username
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function queryByUsername($username){
        return User::where('username',$username)->where('deleted',0)->first();
    }
    /**
     * 根据手机号查找用户
     * @param $mobile
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function queryByMobile($mobile){
        return User::where('mobile',$mobile)->where('deleted',0)->first();
    }
    /**
     * 注册用户
     * @param $user
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function register($user){
        return User::create($user);
    }
    /**
     * 验证验证码是否有效
     * @param $mobile
     * @param $code
     * @return bool
     */
    public function checkCaptcha($mobile,$code){
        if(!($code == Cache::get('reg_captcha_'.$mobile))){
            throw new BusinessException('手机验证码不正确',703);
        }
        return true;
    }
    /**
     * 修改用户信息
     * @param $user_attribute
     * @param $user
     * @throws BusinessException
     */
    public function profile($user_attribute,$user){
        $res=false;
        if(isset($user_attribute['nickname'])&&!empty($user_attribute['nickname'])){
            $res=$user->update($user_attribute);
        }elseif (isset($user_attribute['password'])&&!empty($user_attribute['password'])){
            $user_attribute['password']=Hash::make($user_attribute['password']);
            $res=$user->update($user_attribute);
        }elseif (isset($user_attribute['gender'])){
            $res=$user->update($user_attribute);
        }elseif (isset($user_attribute['avatar'])&&!empty($user_attribute['avatar'])){
            $res=$user->update($user_attribute);
        }
        if(!$res)throw new BusinessException('修改失败',703);
    }
    /**
     * 生成验证码
     * @param $mobile
     * @return int
     */
    public function setCaptcha($mobile){
        $code=1234;
        Cache::put('reg_captcha_'.$mobile,$code,600);
        return $code;
    }
    private function makeRandCode()
    {
        // 生成4位随机数，左侧补0
        return random_int(1000,9999);
    }
    /**
     * 用户收藏
     * @param $user
     * @param $goods_id
     * @return mixed
     */
    public function collect($user,$goods_id){
        return $user->whereHas("collect_goods",function($query)use ($goods_id){
            $query->where('value_id',$goods_id)->where('type',0);
        })->count();
    }
    /**
     * 添加或取消收藏
     * @param $user
     * @param $goods_id
     */
    public function addordelete($user,$goods_id,$type=0){
        $relation=$type==0?$user->collect_goods():'';
        $relation->toggle([$goods_id=>['type'=>$type]]);
    }
    /**
     * 用户搜索历史
     * @param $user_id
     * @return \Illuminate\Support\Collection
     */
    public function history($user_id){
        return SearchHistory::where('user_id',$user_id)->pluck('keyword');
    }
}