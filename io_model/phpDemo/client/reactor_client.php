<?php
namespace client;

class reactor_client
{
    public $client;
    public function __construct($host)
    {
        $this->client = stream_socket_client($host);
    }

    public function main()
    {

        fwrite($this->client,"test \n");
        $data = \fread($this->client,65535);
        echo $data."\n";
        // echo "[CLIENT] start \n";
        // $time1 = time();
        // $this->sendData($this->client,"[CLIENT] this msg is client send to server \n");

        // $data = \fread($this->client,65535);
        // echo ($data);
        // $time2 = time();
        // echo "[CLIENT] end time:".($time2-$time1)."\n";
    }


}