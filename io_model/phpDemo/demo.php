<?php
 // 安装信号
pcntl_signal(SIGIO, "sig_handler");
function sig_handler($sig){
    sleep(2);
    echo "异步io时间";
}
// 是一个安装信号的操作
// pid -》 进程pid ， 要设置信号
// 根据进程设置信号
// posix_getpid获取进程id的
$pid = posix_getpid();
var_dump($pid);
posix_kill(posix_getpid(), SIGIO);


for($i=0;$i<20;$i++){
    echo "abc";
    usleep(500000);

}



pcntl_signal_dispatch();