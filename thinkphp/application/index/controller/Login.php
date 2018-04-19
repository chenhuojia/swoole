<?php
namespace app\index\controller;
use think\Container;
use app\common\lib\Util;
use app\common\lib\Redis;
use app\common\lib\redis\Predis;

class Login extends Container{
    
    
    /**
     * 获取验证码
     * @return unknown
     * ***/
    public function sendPhoneCode(){
        $phone=$_GET['phone_num'];
        $code=mt_rand(1000,9999);
        $swool_http_server=$_SERVER['SWOOLE_HTTP_SERVER'];
        $taskData=[
            'method'=>'sendSms',
            'data'=>[
                'phone'=>$phone,
                'code'=>$code,
            ]
        ];
        $swool_http_server->task($taskData);
        return Util::show(config('code.success')); 
        
    }
    
    /**
     * 用户登录
     * @return unknown
     * ***/
    public function Login(){
        $phone=$_POST['phone_num'];
        $code=$_POST['code'];
        $redis_code=Predis::getInstacne()->get(Redis::smsKey($phone));
        if ($code==$redis_code){
           $data=[
               'user'=>$phone,
               'srcKey'=>md5(Redis::usrKey($phone)),
               'time'=>time(),
               'isLogin'=>true,
           ];
           Predis::getInstacne()->set(Redis::usrKey($phone),$data); 
           return Util::show(config('code.success'),'登录成功',$data);
        }
        return Util::show(config('code.error','登录失败'));
    }
}