<?php
namespace client;

class common_client
{

    protected $client;

    public function __construct($host)
    {
        $this->client = stream_socket_client($host);
    }

    public function sendData($client,$msg)
    {
        fwrite($client,$msg);
    }

}