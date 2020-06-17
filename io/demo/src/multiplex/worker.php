<?php
namespace src\multiplex;

class worker
{
    public $regFunc = [
        'onConnect' => null,
        'onReceive' => null,
        'onClose'   => null,
    ];

    //服务事件的注册函数
    public $onReceive;
    public $onConnect;
    public $onClose;

    //连接池
    public $sockets = [];
    //连接
    public $socket;


    public function __construct($protocol,$ip,$port)
    {
        $this->protocol = $protocol;
        $this->ip       = $ip;
        $this->port     = $port;
        $socketAddress = getSocketAddress($this->protocol,$this->ip,$this->port);
        @stream_set_blocking($this->socket, 0);
        //创建socket服务,监听9001
        $this->socket = stream_socket_server($socketAddress);
        //新进来的连接写入连接池
        $this->sockets[(int)$this->socket] = $this->socket;

        echo $socketAddress." create success multiplex\n";

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

            $read = $this->sockets;


            stream_select($read,$w,$e,1);


            foreach($read as $val){
                var_dump('master');
                var_dump($this->socket);
                var_dump('client');
                var_dump($val);

                if($val === $this->socket){
                    $this->createSocket();
                }else{
                    $this->sendMessage($val);
                }
            }

            usleep(500000);

        }


    }

    public function createSocket()
    {
        $client = stream_socket_accept($this->socket);
        if( is_callable($this->regFunc['onConnect']) ){
            ($this->regFunc['onConnect'])($this,$client);
        }

        $this->sockets[(int)$client] = $client;
    }

    public function sendMessage($client)
    {
        $data = fread($client,65535);
        if($data === "" || $data == false){
            $data = "abc";
        }
        if( is_callable($this->regFunc['onReceive']) ){
            $data = fread($client,65535);
            ($this->regFunc['onReceive'])($this,$client,$data);
        }
    }

    public function send($client,$data)
    {
        fwrite($client,$data);
    }

    public function start()
    {
        $this->accept();
    }

}

