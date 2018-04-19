<?php
//监听所有地址 即内网 外网 本地
$http=new swoole_http_server('0.0.0.0',8811);

/**
 * 设置静态资源浏览
 * ***/
$http->set([
    'enable_static_handler'=>true,
    'document_root'=>'/web/www/swoole/data',
    'worker_num' => 8,   
]);

$http->on('request',function (swoole_http_request $request,swoole_http_response $response){
    print_r($request->get);
    print_r($request->post);
    $response->end("<h1>Httpserver</h1>");
});

$http->start();