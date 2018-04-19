<?php
class AsyncRedis{
    
    public $redis;
    
    public function __construct(){
        
        $this->redis=new swoole_redis();
        
        
    }
    
    public function set(){
        
        $this->redis->connect('127.0.0.1',6379,function($redis,$result){
            echo 'redis start '.PHP_EOL;
            if ($result === false) {
                echo "connect to redis server failed.\n";
                    return ;
            }
            $str=time();
            $redis->set('chjdwl',$str,function($redis,$result){
               var_dump($result); 
               $redis->close();
            });
        });
    }
    
    
    public function get(){
        $this->redis->connect('127.0.0.1',6379,function($redis,$result){
            echo 'redis start '.PHP_EOL;
            if ($result === false) {
                echo "connect to redis server failed.\n";
                return ;
            }
        
            $redis->get('chjdwl',function($redis,$result){
                var_dump($result);
                $redis->close();
            });
        });
    }
}
$obj=new AsyncRedis();
//$obj->set();
$obj->get();