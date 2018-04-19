<?php
/**
 * 修改 thinkphp 文件使其支持swoole 
 * /thinkphp/lib
 * 
 * @author chj
 ****/

class Http_Server{
    
    //监听地址
    const HOST='0.0.0.0';
    
    //端口
    const PORT=8811;
    
    private $config=[
        'enable_static_handler'=>true,
        'document_root'=>'/web/www/swoole/thinkphp/public/static',
        'worker_num' => 4,
        'task_worker_num'=>4,
    ];
    private $requestType=[
        'get','post','header','server'
    ];
    private $http;
    
    public function __construct(){
        $this->http=new swoole_http_server(self::HOST,self::PORT);
        /**
         * 设置静态资源浏览
         * ***/
        $this->http->set($this->config);
    }
    
    
    public function start(){
        $this->http->on('WorkerStart',[$this,'onWorkerStart']);
        $this->http->on('request',[$this,'onRequest']);
        $this->http->on('task',[$this,'onTask']);
        $this->http->on('finish',[$this,'onFinsh']);
        
        $this->http->on('close',[$this,'onClose']);
        $this->http->start();
    }
    
    //事件回调函数 在Worker进程/Task进程启动时发生
    public function onWorkerStart(swoole_server $server, int $worker_id){
        define('APP_PATH', __DIR__ . '/../application/');
        require __DIR__ . '/../thinkphp/start.php';
    }
  
    //请求事件
    public function onRequest(swoole_http_request $request,swoole_http_response $response){
        //转化PHP原生获取请求信息
        $this->setRequestParams($request);  
        $_SERVER['SWOOLE_HTTP_SERVER']=$this->http;
        //获取框架方法得信息
        $contents=$this->getData();
        
        //输出到浏览器
        $response->end($contents);
    }
    
    /**
     * 监听task开始事件
     * @param unknown $ws
     * @param unknown $taskID
     * @param unknown $workID
     * @param unknown $data
     * @return string
     * ***/
    public function onTask($server,$taskID,$workID,$data){
        //分发任务
        $obj = new app\common\lib\task\Task();
        $method=$data['method'];
        $flag=$obj->$method($data['data']);       
        return $flag;
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
    
    
    //获取输出内容
    private function getData(){
        ob_start();
        try {
            think\Container::get('app', [defined('APP_PATH') ? APP_PATH : ''])
            ->run()
            ->send();    
        }catch (\Exception $e){
            //TODO
            print_r($e);
        }
        $contents=ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    
    //把swoole 请求参数 转化为PHP原生参数 即GET　POST SERVER 
    private function setRequestParams($request){
        $_GET=$_POST=$_SERVER=[];
        foreach ($this->requestType as $v){            
            $this->setType($request,$v);
        }
    }
    //转化为PHP原生参数 即GET　POST SERVER 
    private function setType($reqeust,$type){
        if (isset($reqeust->$type)){
            foreach ($reqeust->$type as $k=>$v){
                if ($type=='get'){
                    $_GET[$k]=$v;
                }elseif($type=='post') {
                    $_POST[$k]=$v;
                }else{
                    $_SERVER[strtoupper($k)]=$v;
                }
            }
        }
    }
    
}

$http=new Http_Server();
$http->start();
