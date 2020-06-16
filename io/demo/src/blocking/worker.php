<?php
namespace src\blocking;

class worker
{
    //服务事件的注册函数
    public $onReceive;
    public $onConnect;
    public $onClose;

    //链接
    public $socket;


    public function __construct($protocol,$ip,$port)
    {
        $this->protocol = $protocol;
        $this->ip       = $ip;
        $this->port     = $port;
        $socketAddress = getSocketAddress($this->protocol,$this->ip,$this->port);
        //创建socket服务,监听9001
        $this->socket = stream_socket_server($socketAddress);

        echo $socketAddress." create success \n";

    }

    public function on($type,$func)
    {
        $this->{$type} = $func;
    }

    public function accept()
    {
        while (true) {

            //连接应答
            $client = stream_socket_accept($this->socket);
            if( is_callable($this->onConnect) ){
                ($this->onConnect)($this,$client);
            }

            // $buffer = "";
            // while (!feof($client)) {
            //    $buffer = $buffer.fread($client, 65535);
            // }

            $data = fread($client,65535);
            if( is_callable($this->onReceive) ){
                ($this->onReceive)($this, $client, $data);
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


// $obj = new worker("tcp",'127.0.0.1',"9001");
// $obj->start();