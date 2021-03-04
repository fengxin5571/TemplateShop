<?php

namespace App\Http\Middleware;

use App\Exceptions\BusinessException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    public function unauthenticated($request,array $guards){
        if($request->expectsJson()||in_array('wx',$guards)){
            throw new BusinessException('未登录',501);
        }
        parent::unauthenticated($request,$guards);
    }
}
