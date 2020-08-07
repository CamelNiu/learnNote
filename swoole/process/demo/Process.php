<?php
require "Input.php";
// 多个worker 跟主进程通信，那就会出现阻塞是么？

$workerPool = [];
for ($i=0; $i < 3; $i++) {
    // pcntl_frok
    $process = new Swoole\Process(function($process_son){
        // 子进程空间
        echo "hello father is son";
        // Input::info();
        // while (true) {
        //   sleep(1);
        // }
        // $process_son->write('接收到信息 father');
    }, true, true);
    // 父进程空间
    $pid = $process->start();
    // $process->write('hello 子进程'.$pid);
    Input::info($process->read(), "读取到son 进程空间中的信息");
    $workerPool[$pid] = $process;
    // Input::info($process->read(), "读取到son 进程空间中的信息");

    // swoole_event_add($process->pipe, function($pipe) use ($process){
        Input::info($process->read(), "读取到son 进程空间中的信息");
    // });
}

// 1. 可以子进程先执行完，然后再读取
// foreach ($workerPool as $key => $value) {
//     Input::info($process->read(), "读取到son 进程空间中的信息");
// }

// 2. 可以子进程先执行完，然后再读取

// 主进程
// pcntl_fork();
