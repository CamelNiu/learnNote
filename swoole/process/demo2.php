<?php


for($i=0;$i<2;$i++){
    $process = new Swoole\Process(function($process_son){
        $pid = posix_getpid();

        var_dump($pid);
        $data = $process_son->pop();

        var_dump($pid.$data);
    });
    //$process->useQueue(1,2 | swoole_process::IPC_NOWAIT);
    $process->useQueue(1,2);

    if($i == 1){
        $data = $process->push('[father] father to son');
    }

    $process->start();
}