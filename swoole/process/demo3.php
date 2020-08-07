<?php
ini_set('default_socket_timeout', -1);
$workerNum = 2;

$pool = new Swoole\Process\Pool($workerNum);

$redis = new Redis();
$redis->pconnect('127.0.0.1',6379);

$pool->on('WorkerStart',function($pool,$workerId)use($redis){
    $pid = posix_getpid();
    $running = true;
    echo printf("执行worker进程,进程id为 %s;,workerId 为 %s\n",$pid,$workerId);
    pcntl_signal(SIGTERM,function()use(&$runing){
        var_dump('nidadeqiu');
        $running = false;
    });

    var_dump($running);

    $key = "key1";

    while ($running) {
        pcntl_signal_dispatch();
        $msg = $redis->brpop($key,0);
        var_dump($msg);

        if($msg == null) continue;
        var_dump("continue");
    }

});

$pool->on('WorkerStop',function($pool,$workerId){
    var_dump($workerId);
});

$pool->start();
