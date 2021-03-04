<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/1/29
 * Time: 10:21 AM
 */
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Wx\AuthController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Wx\AddressController;
use App\Http\Controllers\Wx\CatalogController;
use App\Http\Controllers\Wx\BrandController;
use App\Http\Controllers\Wx\GoodsController;
use App\Http\Controllers\Wx\OtherController;
Route::post('/auth/register',[AuthController::class,'register']);
Route::post('/auth/regCaptcha',[AuthController::class,'regCaptcha']);
Route::post('/auth/login',[AuthController::class,'login']);
Route::post('storage/upload',[UploadController::class,'picUpload']);
Route::group(['middleware'=>'auth:wx'],function (){

    Route::get('/auth/info',[AuthController::class,'info']);
    Route::post('auth/logout',[AuthController::class,'logout']);
    Route::post('auth/reset',[AuthController::class,'reset']);
    Route::get('/user/index',function (){});
    Route::post('auth/profile',[AuthController::class,'profile']);

    Route::group(['prefix'=>'address'],function (){
        Route::get('list',[AddressController::class,'list']);
        Route::post('save',[AddressController::class,'save']);
    });

    Route::group(['prefix'=>'catalog'],function (){
        Route::get('index',[CatalogController::class,'catalog']);
        Route::get('current',[CatalogController::class,'catalog']);
    });

    Route::group(['prefix'=>'brand'],function (){
        Route::get('list',[BrandController::class,'list']);
        Route::get('detail/{id}',[BrandController::class,'detail']);
    });

    Route::group(['prefix'=>'goods'],function(){
        Route::get('count',[GoodsController::class,'count']);
        Route::get('category',[GoodsController::class,'category']);
        Route::get('list',[GoodsController::class,'list']);
        Route::get('detail',[GoodsController::class,'detail']);
    });
    Route::get('search/list',[OtherController::class,'search']);
    Route::group(['prefix'=>'cart'],function (){
        Route::get('goodscount',function(){

        });

    });

    Route::group(['prefix'=>'collect'],function (){
        Route::post('addordelete',[OtherController::class,'addordelete']);
    });
});