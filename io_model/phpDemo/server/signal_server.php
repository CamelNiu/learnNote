<?php
namespace server;

class signal_server extends common_server
{

    protected $server;

    public function __construct($host)
    {

        $this->server = new \src\signal_worker($host);
    }

    public function main()
    {
        $this->testReceive();
        $this->testSend();
        $this->server->start();
    }
}