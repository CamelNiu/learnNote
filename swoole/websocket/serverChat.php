<?php
require "./config.php";
$ws = new Swoole\WebSocket\Server($config['ws']['host'],$config['ws']['port']);


$ws->on('open',function($ws,$request){
    $ws->push($request->fd, "Server:connect success\n");
    $fds = $ws->getClientList();
    go(function () use($fds,$ws) {
        while (true) {
            foreach ($fds as $key => $fd) {
                if ($ws->exists($fd)) {
                    $ws->push($fd, 'connect success');
                }
            }
            usleep(1000000);
        }
    });
});

$ws->on('connect',function(Swoole\Server $ws, int $fd, int $reactorId){
    // $fds = $ws->getClientList();
    // while (true) {
    //     var_dump(count($fds));
    //     sleep(2);
    // }
});

//监听WebSocket消息事件
$ws->on('message', function ($ws, $frame) {
    $msg = $frame->data;
    $fds = $ws->getClientList();
    // while (true) {
    //     foreach ($fds as $key => $fd) {
    //         if ($ws->exists($fd)) {
    //             $ws->push($fd, '123');
    //         }
    //     }
    //     sleep(1);
    // }
    foreach ($fds as $key => $fd) {
        if ($ws->exists($fd)) {
            $ws->push($fd, $msg);
        }
    }
});

//监听WebSocket连接关闭事件
$ws->on('close', function ($ws, $fd) {
    echo "client-{$fd} is closed\n";
});

$ws->start();