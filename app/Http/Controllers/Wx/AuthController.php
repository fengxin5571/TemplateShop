<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/1/29
 * Time: 10:24 AM
 */
namespace App\Http\Controllers\Wx;
use App\Exceptions\BusinessException;
use App\Http\Controllers\CommonController;
use App\Http\Requests\LoginPost;
use App\Http\Requests\RegCaptchaPost;
use App\Http\Requests\RegisterPost;
use App\Http\Requests\UserProfilePost;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthController extends CommonController {
    private $userService;
    public function __construct()
    {
        $this->userService=app()->make(UserService::class);
    }
    /**
     * 用户注册
     * @param RegisterPost $registerPost
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterPost $registerPost){
        $validated = $registerPost->validated();
        if($this->userService->queryByUsername($validated['username'])){
            throw new BusinessException('用户已经注册',704);
        }
        if($this->userService->queryByMobile($validated['mobile'])){
            throw new BusinessException('手机号已经注册',705);
        }
        $this->userService->checkCaptcha($validated['mobile'],$validated['code']);
        $insert_data=[
            'username'=>$validated['username'],
            'password'=>Hash::make($validated['password']),
            'avatar'  =>'',
            'mobile'  =>$validated['mobile'],
            'nickname'=>$validated['username'],
            'last_login_time'=>Carbon::now()->toDateTimeString(),
            'last_login_ip'  =>request()->getClientIp()
        ];
        if(!$user=$this->userService->register($insert_data)){
            throw new BusinessException('注册失败',706);
        }
        return $this->success([
            'token'=>'',
            'userInfo'=>[
                'username'=>$user->username,
                'avatarUrl'=>$user->avatar
            ]
        ],'注册成功');
    }
    /**
     * 发送验证码
     * @param RegCaptchaPost $captchaPost
     * @return \Illuminate\Http\JsonResponse
     */
    public function regCaptcha(RegCaptchaPost $captchaPost){
        $validated = $captchaPost->validated();
        $lock=Cache::add('reg_captcha_lock'.$validated['mobile'],1,60);
        if(!$lock){
            throw new BusinessException('验证码未超时1分钟,不能发送',702);
        }
        $code=$this->userService->setCaptcha($validated['mobile']);
        //todo 发送代码
        return $this->success(null,'发送成功');
    }
    /**
     * 登录
     * @param LoginPost $loginPost
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function login(LoginPost $loginPost){
        $validated=$loginPost->validated();
        $user=$this->userService->queryByUsername($validated['username']);
        if(!$user) throw  new BusinessException('用户不存在',700);
        if(!Hash::check($validated['password'],$user->password)) throw new BusinessException('密码错误',700);
        $user->update([
            'last_login_time'=>Carbon::now()->toDateTimeString(),
            'last_login_ip'  =>request()->getClientIp()
        ]);
        if(!$token=auth('wx')->login($user)) throw  new BusinessException('登录失败',700);
        return $this->success([
            'token'=>$token,
            'userInfo'=>[
                'nickName'=>$user->nickname,
                'avatarUrl'=>$user->avatar
            ]
        ],'登录成功');
    }
    /**
     * 用户信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(){
        $user= Auth::guard('wx')->user();
        return $this->success([
            'nickName'=>$user->nickname,
            'avatar'=>$user->avatar,
            'gender'=>$user->gender,
            'mobile'=>$user->mobile
        ]);
    }
    /**
     * 修改密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function reset(Request $request){
        $this->userService->profile(['password'=>$request->input('password')],Auth::guard('wx')->user());
        return $this->success(null,'修改成功');
    }
    /**
     * 修改信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws BusinessException
     */
    public function profile(Request $request){
        $this->userService->profile($request->all(),Auth::guard('wx')->user());
        return $this->success([],'修改成功');
//
    }
    /**
     * 登出
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        Auth::guard('wx')->logout();
        return $this->success(null,'ok');
    }
}