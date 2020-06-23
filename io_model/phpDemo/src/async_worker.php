<?php
//阻塞socket,worker实例
namespace src;

use Swoole\Event;

class async_worker extends common_worker
{
    public function __construct($host)
    {
        parent::__construct($host);
        echo "[SERVER] async model \n";
    }

    public function accept()
    {
        Event::add($this->socket,$this->createClientConn($this->socket));

    }


    public function createClientConn($socket)
    {
        return function($socket){
            $client = stream_socket_accept($socket);
            if( !empty($client) ){
                echo "[SERVER] async connect success \n";
            }

            Event::add($client,$this->execTask($client));

            // $data = \fread($client,65535);
            // if(is_callable($this->funcType['onReceive'])){
            //     ($this->funcType['onReceive'])($this,$client,$data);
            // }

            // if(is_callable($this->funcType['onSend'])){
            //     ($this->funcType['onSend'])($this,$client);
            // }

        };
    }


    public function execTask($socket)
    {
        return function($socket){

            $data = \fread($socket,65535);

            if(empty($data)){
                swoole_event_del($socket);
                fclose($socket);
                return;
            }

            if(is_callable($this->funcType['onReceive'])){
                ($this->funcType['onReceive'])($this,$socket,$data);
            }

            if(is_callable($this->funcType['onSend'])){
                ($this->funcType['onSend'])($this,$socket);
            }

            // swoole_event_del($socket);
            // fclose($socket);

        };
    }


}