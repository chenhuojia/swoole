<?php

$client=new swoole_client(SWOOLE_SOCK_TCP);
$client->connect('127.0.0.1',9501);
fwrite(STDOUT, '请输入消息：');
$msg=trim(fgets(STDIN));
$client->send($msg);
$result=$client->recv();
echo $result;
