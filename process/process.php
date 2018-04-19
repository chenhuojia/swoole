<?php
class Process{
    
    public $process;
    public $pid;
    public $redirect_stdin_stdout=FALSE;
    public function __construct(){
        
        $this->process=new swoole_process([$this,'callback_function'],$this->redirect_stdin_stdout);
       echo $this->pid=$this->process->start();
       swoole_process::wait(true);
    }
    
    public static function callback_function(swoole_process $worker){
        $worker->exec('/web/server/php7/bin/php',[__DIR__.'/../server/http_server.php']);
    }
}
(new Process());

/* $process=new swoole_process(function (swoole_process $worker){
    $worker->exec('/web/server/php7/bin/php',[__DIR__.'/../server/http_server.php']);
},false);
echo $pid=$process->start();

swoole_process::wait(true); */