<?php
namespace app\index\controller;
use think\Controller;
use app\common\lib\Util;

class Send extends Controller{
    
    public function index(){
       return Util::show(config('code.error'),'error');
    }
}