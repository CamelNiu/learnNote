<?php
namespace client;
//阻塞模型客户端实例
class signal_client extends common_client
{

    public function __construct($host)
    {
        parent::__construct($host);
    }


    public function main()
    {
        echo "[CLIENT] start \n";
        $time1 = time();
        $this->sendData($this->client,"[CLIENT] this msg is client send to server \n");

        $data = \fread($this->client,65535);
        echo ($data);
        $time2 = time();
        echo "[CLIENT] end time:".($time2-$time1)."\n";
    }
}