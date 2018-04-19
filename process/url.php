<?php
class curls{
    
    public $list=[
        'http://baidu.com',
        'http://qq.com',
        'http://aliyun.com',
    ];
    
    public $workers;
    public function __construct(){
        echo 'curl-process-start-time: '.date('Ymd H:i:s').PHP_EOL;
        for ($i=0;$i<3;$i++){
            $process=new swoole_process(function(swoole_process $worker) use($i) {
                $conent=$this->curlt($this->list[$i]);
                echo $conent.PHP_EOL;
            },true);
            $pid=$process->start();
            $this->workers[$pid]=$process;
        }
        
        foreach ($this->workers as $process){
            echo $process->read();
        }
        
        echo 'curl-process-end-time: '.date('Ymd H:i:s').PHP_EOL;
    }
    
    
    public function curlt($url){
        sleep(1);
        return $url.' success'.PHP_EOL;
    }
}

(new curls());