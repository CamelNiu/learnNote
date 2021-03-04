<?php

$server = new Swoole\WebSocket\Server("127.0.0.1", 9501);

$server->on('open', function (Swoole\WebSocket\Server $server, $request) {
    $server->push(1,"连接成功");
});

$server->on("message",function(Swoole\WebSocket\Server $server, $frame){

        $message = $frame->data;
        var_dump($message);
        $server->push(1,"I am Swoole");

});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();