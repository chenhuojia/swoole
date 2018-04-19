<?php
namespace app\common\lib;
class Redis{
    
    /**
     * 验证码 redis 前缀
     * @var string
     * ***/
    public static $pre='sms_';
    
    /**
     * 用户redis 前缀
     * @var string
     * ***/
    public static $user_pre='usr_';
    
    /**
     * 验证码 redis key
     * @param unknown $phone
     * @return string
     * ***/
    public static function smsKey($phone){
        return self::$pre.$phone;
    }
    
    /**
     * 用户 redis key
     * @param unknown $phone
     * @return string
     * ***/
    public static function usrKey($phone){
        return self::$user_pre.$phone;
    }
    
    /**
     * 协程redis设置缓存
     * @param unknown $phone
     * @param unknown $code***/
    public static function setKey($phone,$code){
        $redis=new \Swoole\Coroutine\Redis();
        $redis->connect(config('redis.host'),config('redis.port'));
        $redis->set(self::smsKey($phone), $code,config('redis.exprie'));
    }
}