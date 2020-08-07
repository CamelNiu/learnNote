<?php
require "Input.php";
// 多个worker 跟主进程通信，那就会出现阻塞是么？


for ($i=0; $i < 2; $i++) {

    $process = new Swoole\Process(function($process_son){
        // 子进程空间
        Input::info($process_son->pop(), 'son');
        // $process_son->push('hello taher 进程 我是 son');
    } );
    $process->useQueue(1, 2 | swoole_process::IPC_NOWAIT ); // 启用消息队列通信

    $process->push('hello 子进程 我是 father');

    $pid = $process->start();
    Input::info($process->pop(), 'father');
}
