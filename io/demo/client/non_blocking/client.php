<?php
namespace client\non_blocking;

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
        //设置程序为非阻塞
        stream_set_blocking($this->socket,0);
        $new = time();
        fwrite($this->socket,'client success');

        $data = $this->nonBlcGetData();
        var_dump($data);

        echo "\n".time()-$new."\n";

        fclose($this->socket);
    }

    public function nonBlcGetData()
    {
        while (!feof($this->socket)) {
            $data = fread($this->socket,65535);
            if( !empty( $data ) ){
                return $data;
            }

        }
    }

}