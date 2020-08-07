<?php

require "Input.php";


$workerNum = 2;
// 创建一个进程池
$pool = new Swoole\Process\Pool($workerNum);

$pool->on("WorkerStart", function ($pool, $workerId) {
    $running = true;

    pcntl_signal(SIGTERM, function () use (&$running) {
        $running = false;
    });

    echo "Worker#{$workerId} is started\n";

    $retCount = 3; // 尝试重启的总次数
    $ret = 0; // 记录重启的次数
    RETRRR:{
        try {
            $redis = new Redis();
            $redis->pconnect('127.0.0.1', 6379);
            $key = "key1";
            while ($running) {
               $msg = $redis->brpop($key, 0);
               pcntl_signal_dispatch();
               if ( $msg == null) continue;
               var_dump($msg);
            }
        } catch (\Exception $e) {
            if ($ret == $retCount) {
                echo "尝试上限"."\n";
            } else {
                sleep(1);
                $ret ++;
                echo "尝试重连 ".$ret."\n";
                goto RETRRR;
            }
        }
    }
});


$pool->on('workerStop', function (Swoole\Process\Pool $pool, int $workerId) {
    var
});

$pool->start();
