<?php
namespace server;
//阻塞服务端
class async_server extends common_server
{

    protected $server;

    public function __construct($host)
    {
        $this->server = new \src\async_worker($host);
    }

    public function main()
    {

        $this->testReceive();
        $this->testSend();
        $this->server->start();
    }





}