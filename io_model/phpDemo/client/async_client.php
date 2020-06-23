<?php
namespace client;
//阻塞模型客户端实例
class async_client extends common_client
{

    public function __construct($host)
    {
        parent::__construct($host);
    }

    //在服务器返回数据设置了延时5s。打开多个客户端的时候，可以发现后面打开的可短短延时大于5s，就是因为前面的进程在阻塞，导致的。这就是阻塞模型
    public function main()
    {
        // echo "[CLIENT] start \n";
        // $time1 = time();
        // $this->sendData($this->client,"[CLIENT] this msg is client send to server \n");

        // $data = \fread($this->client,65535);
        // echo ($data);
        // $time2 = time();
        // echo "[CLIENT] end time:".($time2-$time1)."\n";

        $this->longConn();

    }
}