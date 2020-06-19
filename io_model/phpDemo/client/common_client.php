<?php
namespace client;

class common_client
{

    protected $client;

    public function __construct($host)
    {
        $this->client = stream_socket_client($host);
    }

    public function sendData($client,$msg)
    {
        fwrite($client,$msg);
    }

    //粗暴实现长连接,server不关闭,每个两秒发送一次数据就是长连接。但是注意server要用多路复用。因为其他server容易循环到创建新连接的时候被阻塞
    public function longConn()
    {
        while(true){
            echo "[CLIENT] start \n";
            $time1 = time();
            $this->sendData($this->client,"[CLIENT] this msg is client send to server \n");

            $data = \fread($this->client,65535);
            echo ($data);
            $time2 = time();
            echo "[CLIENT] end time:".($time2-$time1)."\n";

            sleep(2);

        }
    }

}