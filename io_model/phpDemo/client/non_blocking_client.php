<?php
namespace client;
//阻塞模型客户端实例
class non_blocking_client extends common_client
{

    public function __construct($host)
    {
        parent::__construct($host);
        //这个socket设置了非阻塞，并不是说设置了这个非阻塞，那么这个socket就非阻塞了，而是仅仅对于客户端是非阻塞
        //假设服务端设置了非阻塞，服务端顶多不阻塞这个socket。客户端依然阻塞。
        stream_set_blocking($this->client,0);
    }

    //在服务器返回数据设置了延时5s。打开多个客户端的时候，可以发现后面打开的可短短延时大于5s，就是因为前面的进程在阻塞，导致的。这就是阻塞模型
    public function main()
    {
        echo "[CLIENT] start \n";
        $time1 = time();
        $this->sendData($this->client,"[CLIENT] this msg is client send to server \n");

        $data = \fread($this->client,65535);
        echo ($data);
        $time2 = time();
        echo "[CLIENT] end time:".($time2-$time1)."\n";

        //执行完上面的打印，再轮询i/o数据，非阻塞，不会阻塞上面的代码
        while(!feof($this->client)){
            $data = \fread($this->client,65535);
            echo ($data);
        }
    }
}