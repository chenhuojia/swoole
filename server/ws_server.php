<?php

$server = new swoole_websocket_server("0.0.0.0", 8812);
/**
 * 设置静态资源浏览
 * ***/
$server->set([
    'enable_static_handler'=>true,
    'document_root'=>'/web/www/swoole/data'
]);
$server->on('open','onOpen');
function onOpen($server,$request){
    //print_r($request);
}
/* $server->on('open', function (swoole_websocket_server $server, $request) {
    echo "server: handshake success with fd{$request->fd}\n";
}); */
    
$server->on('message', function (swoole_websocket_server $server, $request) {
    echo "receive from {$request->fd}:{$request->data},opcode:{$request->opcode},fin:{$request->finish}\n";
    $server->push($request->fd, "this is server");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});
    
$server->start();