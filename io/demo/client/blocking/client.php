<?php
namespace client\blocking;

class client
{
    public $protocol = "tcp";
    public $ip       = "127.0.0.1";
    public $port     = "9001";

    public $socket;

    function __construct()
    {
        $socketAddress = getSocketAddress($this->protocol,$this->ip,$this->port);
        $this->socket = stream_socket_client($socketAddress);
    }

    public function main()
    {
        $new = time();
        fwrite($this->socket,'client success');
        fread($this->socket,65535);
        fclose($this->socket);
        echo "\n".time()-$new;
    }

}