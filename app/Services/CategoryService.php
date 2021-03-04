<?php
/**
 * Created by PhpStorm.
 * User: fengxin
 * Date: 2021/2/3
 * Time: 10:18 AM
 */
namespace App\Services;
use App\Models\Category;

class CategoryService{
    protected $categoryes;
    public function __construct()
    {
        $category=Category::all();
        $this->categoryes=collect($this->getTree($category));
    }
    public function getCategory(){
        return $this->categoryes;
    }
    public function currentCategory($id){
        if($id){
            $data[]=$this->categoryes->where('id',$id)->first();
            $data[]=$data[0]->sub;
        }else{
            $data[]=$this->categoryes->first();
            $data[]=$data[0]->sub;
        }
        return $data;
    }
    public function findById($id){
        $category=Category::where('id',$id)->first();
        return $category;
    }
    public function findByPid($id){
        $categoryes=Category::where('pid',$id)->get();
        return $categoryes;
    }
    protected function getTree($item=[],$pid=0,$sub='sub',$level=1){
        $data=array();
        foreach ($item as $k=>$v){
            if($v['pid']==$pid){
                $v['level']=$level;
                $v[$sub]=$this->getTree($item,$v['id'],$sub,$level+1);
                $data[]=$v;
            }
        }
        return $data;
    }
}