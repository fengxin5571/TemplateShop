<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/1/29
 * Time: 12:04 PM
 */
namespace App\Http\Controllers;
class CommonController extends Controller{
    public function codeReturn($errno,$errmsg,$data = null){
        $ret=['errno'=>$errno,'errmsg'=>$errmsg];
        if(!is_null($data)){
            $ret['data']=$data;
        }
        return response()->json($ret);
    }
    public function success($data,$msg='ok'){
        return $this->codeReturn(0,$msg,$data);
    }
    public function fail($errno,$errmsg){
        return $this->codeReturn($errno,$errmsg);
    }
}