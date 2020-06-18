<?php
namespace server;
//阻塞服务端
class blocking_server extends common_server
{

    protected $server;

    public function __construct($host)
    {
        $this->server = new \src\blocking_worker($host);
    }

    public function main()
    {
        $this->testReceive();
        $this->testSend();
        $this->server->start();
    }





}