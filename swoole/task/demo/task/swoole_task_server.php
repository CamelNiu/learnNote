<?php



$serv = new Swoole\Server("127.0.0.1", 9501);

//设置异步任务的工作进程数量
$serv->set([
    'worker_num' => 4,
    'task_worker_num' => 4,
]);

//此回调函数在worker进程中执行
$serv->on('receive', function($serv, $fd, $from_id, $data) {
    $data = "abc";
    //投递异步任务
    $task_id = $serv->task($data);
    if($task_id === false){
        echo "task error\n";
    }else{
        echo "task success\n";
    }
});

//处理异步任务(此回调函数在task进程中执行)
$serv->on('task', function ($serv, $task_id, $from_id, $data) {

    for($i=0;$i<500;$i++){
        file_put_contents('./abc.log',$data.$i.PHP_EOL,FILE_APPEND);
    }
    //返回任务执行的结果
    $serv->finish('write doc success');
});

//处理异步任务的结果(此回调函数在worker进程中执行)
$serv->on('finish', function ($serv, $task_id, $data) {
    echo "AsyncTask[$task_id] Finish: $data".PHP_EOL;
});

$serv->start();