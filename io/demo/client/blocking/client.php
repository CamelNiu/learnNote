<?php
namespace client\blocking;

class client
{
    public $protocol = "tcp";
    public $ip       = "127.0.0.1";
    public $port     = "9001";

    public $client;

    function __construct()
    {
        $socketAddress = getSocketAddress($this->protocol,$this->ip,$this->port);
        //创建socket服务,监听9001
        $this->client = stream_socket_client($socketAddress);
    }

    public function main()
    {
        $new = time();
        fwrite($this->client,'client success');
        fread($this->client,65535);
        fclose($this->client);
        echo "\n".time()-$new;
    }

}