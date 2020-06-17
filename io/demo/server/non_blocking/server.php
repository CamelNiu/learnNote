<?php
namespace server\non_blocking;



class server
{

    public $protocol = "tcp";
    public $ip       = "127.0.0.1";
    public $port     = "9001";

    public $server;

    public function __construct()
    {
        $this->server = new \src\non_blocking\worker($this->protocol,$this->ip,$this->port);
    }

    public function main()
    {
        $this->testConnect();
        $this->testReceive();
        $this->server->start();
    }

    public function testReceive()
    {
        $this->server->on('onReceive',function($socket,$client,$data){
            echo $data."\n";
            sleep(3);
            //var_dump(microtime(true));
            $socket->send($client,microtime(true)."  hello word client \n");
        });
    }

    public function testConnect()
    {
        $this->server->on('onConnect',function($socket,$client){
            echo "connect success \n";
            echo date('Y-m-d H:i:s')."\n";
        });
    }
}