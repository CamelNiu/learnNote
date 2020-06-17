<?php

namespace src\non_blocking;

class worker
{
    public $regFunc = [
        'onConnect' => null,
        'onReceive' => null,
        'onClose'   => null,
    ];

    public $socket;

    public function __construct($protocol,$ip,$port)
    {
        $this->protocol = $protocol;
        $this->ip       = $ip;
        $this->port     = $port;
        $socketAddress = getSocketAddress($this->protocol,$this->ip,$this->port);
        $this->socket = stream_socket_server($socketAddress);
        echo $socketAddress." create success \n";
    }

    public function on($type,$func)
    {
        if(!in_array($type,array_keys($this->regFunc))){
            throw new \Exception($type."函数不可绑定",-1);
        }
        $this->regFunc[$type] = $func;
    }

    public function accept()
    {
        while (true) {
            $client = stream_socket_accept($this->socket);
            if( is_callable($this->regFunc['onConnect']) ){
                ($this->regFunc['onConnect'])($this,$client);
            }
            if( is_callable($this->regFunc['onReceive']) ){
                $data = fread($client,65535);
                ($this->regFunc['onReceive'])($this,$client,$data);
            }
            fclose($client);
        }
    }

    public function send($conn,$data)
    {
        fwrite($conn,$data);
    }

    public function start()
    {
        $this->accept();
    }

}