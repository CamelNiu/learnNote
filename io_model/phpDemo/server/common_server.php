<?php
namespace server;

class common_server
{




    public function testReceive()
    {
        $this->server->on('onReceive',function($socket,$client,$data){
            echo ($data);
        });
    }

    public function testSend()
    {
        $this->server->on("onSend",function($socket,$client){
            sleep(5);
            $socket->send($client,"[SERVER] this message is server send to client,client receive");
        });
    }

}