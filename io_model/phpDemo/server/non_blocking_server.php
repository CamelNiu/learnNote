<?php
namespace server;
//非阻塞服务端
class non_blocking_server extends common_server
{

    protected $server;

    public function __construct($host)
    {
        $this->server = new \src\non_blocking_worker($host);
    }

    public function main()
    {
        $this->testReceive();
        $this->testSend();
        $this->server->start();
    }

}