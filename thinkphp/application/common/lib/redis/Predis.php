<?php
/**

* 单例redis类用途描述

* @date: 2018年4月13日 下午7:12:54

* @author: chj

*/
namespace app\common\lib\redis;
class Predis{
    
    /**
     * 单例
     * @var unknown
     * ***/
    public static $instance;
    
    /**
     * redis 对象
     * @var unknown***/
    public $redis;
    
    private function __construct(){
       $this->redis=new \Redis();
       $result=$this->redis->connect(config('redis.host'),config('redis.port'));
       if (!$result) {
           throw new \Exception('redis connect error');
       }
    }
 
    /**
     * 单一入口
     * @return \app\common\lib\redis\unknown
     * ***/
    public static function getInstacne(){
        if (!self::$instance){
            self::$instance=new self();
        }
        return self::$instance;
    }
    
    /**
     * 设置缓存
     * @param unknown $key
     * @param unknown $value
     * @param number $exprie
     * @return void|boolean
     * ***/
    public function set($key,$value,$exprie=0){
        if (!$key) return ;
        if (is_array($value)){
            $value=json_encode($value,JSON_UNESCAPED_UNICODE);
        }
        if (!$exprie){
            return $this->redis->set($key,$value);
        }else {
            return $this->redis->setex($key,$exprie,$value);
        }
    }
    
    /**
     * 获取缓存
     * @param unknown $key
     * @return void|mixed|string |array
     * ***/
    public function get($key){
        if (!$key) return ;
        $value=$this->redis->get($key);
        if ($value && !is_null(json_decode($value))){
            return json_decode($value,true);
        }
        return $value;
    }
}