<?php
/**
* swoole 任务 文件
* @date: 2018年4月17日
* @author: chj
* @version: version
*/
namespace app\common\lib\task;
use app\common\lib\ali\Sms;
use app\common\lib\redis\Predis;
use app\common\lib\Redis;
class Task{
    
    /**
     * 异步发送验证码
     * @param unknown $data
     * ***/
    public function sendSms($data){
         try {
             $status=Sms::sendSms($data['phone'], $data['code']);
         }catch (\Exception $e){
            return false;
         } 
         //把code 存储在redis
         if ($status==true){
             Predis::getInstacne()->set(Redis::smsKey($data['phone']), $data['code'],config('redis.exprie'));
         }else{
             return false;
         } 
        return true;
    }
}