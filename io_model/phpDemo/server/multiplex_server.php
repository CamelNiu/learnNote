<?php
namespace server;

class multiplex_server extends common_server
{

    protected $server;

    public function __construct($host)
    {

        $this->server = new \src\multiplex_worker($host);
    }

    public function main()
    {
        $this->testReceive();
        $this->testSend();
        $this->server->start();
    }
}