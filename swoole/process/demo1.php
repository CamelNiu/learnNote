<?php

//多进程以及管道通讯

/**
 *
 */
class ProcessDemo
{
    public function main()
    {
        var_dump('abc');
    }
}


( new ProcessDemo() ) ->main();

// use Swoole\Process;

// $worker = [];

// for($n = 1;$n<=3;$n++){
//     $process = new Process(function($process_son)use($n){


//         sleep(2);
//         $process_son->write('[son] this is son');

//     },true,true);

//     $pid = $process->start();
//     $worker[$pid] = $process;

//     Swoole\Event::add($process->pipe,function($pipe)use($process){
//         $data = $process->read();
//         var_dump($data);
//     });


// }

// // foreach ($worker as $key => $value) {
// //     $data = $value->read();
// //     var_dump($data);
// // }


// for($n=3;$n>=0;$n--){
//     $status = Process::wait(true);

// }

