<?php
require "Input.php";
$workerNum = 2;
// 创建一个进程池
$pool = new Swoole\Process\Pool($workerNum);

$pool->on('workerStart', function (Swoole\Process\Pool $pool, int $workerId) {
    Input::info($workerId, "执行 worker ".$workerId);

    while (true) {

        sleep(1);
    }
});

$pool->on('workerStop', function (Swoole\Process\Pool $pool, int $workerId) {
    Input::info($workerId, "关闭子进程 ".$workerId);
});

$pool->start();
