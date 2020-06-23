<?php


$fp = stream_socket_client("tcp://www.qq.com:80", $errno, $errstr, 30);
fwrite($fp,"GET / HTTP/1.1\r\nHost: www.qq.com\r\n\r\n");

Swoole\Event::add($fp, function($fp) {
    $resp = fread($fp, 8192);
    //socket处理完成后，从epoll事件中移除socket
    Swoole\Event::del($fp);
    fclose($fp);
});
echo "Finish\n";  //Swoole\Event::add 不会阻塞进程，这行代码会顺序执行