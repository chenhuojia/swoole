<?php
class Ws{
    
    const HOST='0.0.0.0';
    const PORT='8812';
    public $ws;
    
    public function __construct(){
        $this->ws=new swoole_websocket_server(self::HOST,self::PORT);
        
        //设置参数
        $this->ws->set([
            'task_worker_num'=>2,
            'worker_num'=>2
        ]);
        
        //注册事件
        
        $this->ws->on('open',[$this,"onOpen"]);
        $this->ws->on('message',[$this,'onMessage']);
        
        $this->ws->on('task',[$this,'onTask']);
        $this->ws->on('finish',[$this,'onFinsh']);
        
        $this->ws->on('close',[$this,'onClose']);
        
        //启动ws
        $this->ws->start();
    }
    

    /**
     * 监听ws连接事件
     * @param unknown $ws
     * @param unknown $request
     * ***/
    public function onOpen($ws,$request){
        var_dump($request->fd);
        $this->tiemtick();
    }
    
    /**
     * 监听ws消息事件
     * @param unknown $ws
     * @param unknown $frame
     * ***/
    public function onMessage($ws,$frame){
        echo 'ser-push-message:'.$frame->data."\n";
        //TODO
        $ws->task(['id'=>1,'cilent'=>$frame->fd]);
        
        $this->timerafter($ws,$frame);
        
        $ws->push($frame->fd,"server-push:". date("Y-m-d H:i:s"));
    }
    
    /**
     * 监听task开始事件
     * @param unknown $ws
     * @param unknown $taskID
     * @param unknown $workID
     * @param unknown $data
     * @return string
     * ***/
    public function onTask($ws,$taskID,$workID,$data){
        print_r($data);
        sleep(3);
        return "on task finsh";
    }
    
    /**
     * 监听task完成事件
     * @param unknown $ws
     * @param unknown $taskID
     * @param unknown $data
     * ***/
    public function onFinsh($ws,$taskID,$data){
        echo "taskId:{$taskID}\n";
        echo "taskreturn:{$data}\n";
    }
    
    /**
     * 监听ws关闭事件
     * @param unknown $ws
     * @param unknown $fd
     * ***/
    public function onClose($ws,$fd){
        echo 'client_id:'.$fd."\n";
    }
    
    /**
     * 间隔时钟定时器事件
     * ***/
    public function tiemtick(){
        swoole_timer_tick(2000,function($time_id,$params){
            echo "timeout:".$time_id.' '.$params.PHP_EOL;
        },3);
    }
    
    /**
     * 延时定时器事件
     * @param unknown $ws
     * @param unknown $frame
     * ***/
    public function timerafter($ws,$frame){
        swoole_timer_after(5000,function() use($ws,$frame){
            var_dump($frame);
        });
    }
    
}
(new Ws());