<?php
namespace src;

class multiplex_worker extends common_worker
{

    public $sockets = [];

    public function __construct($host)
    {

        parent::__construct($host);

        stream_set_blocking($this->socket,0);
        echo "[SERVER] ".$this->host." set server non_blocking \n";

        $this->sockets[(int)$this->socket] = $this->socket;

    }

    public function accept()
    {
        while (true) {

            $read = $write = $except = [];
            $read = $this->sockets;
            // echo "start \n";
            // var_dump($read);
            stream_select($read, $write, $except,1);
            // echo "end \n";
            //var_dump($read);

            //var_dump($read);

            foreach($read as $val){
                if($val === $this->socket){
                    $this->createClient();
                }else{
                    $this->task($val);
                }
            }
        }
    }

    public function createClient()
    {
        $client = stream_socket_accept($this->socket);

        $this->sockets[ (int)$client ] = $client;
        echo "[SERVER] client connect is success \n";
    }

    public function task($client)
    {
        $data = fread($client,65535);

        if( $data == "" || $data == false ){
            fclose($client);
            unset($this->sockets[(int)$client]);
            return;
        }

        if(is_callable($this->funcType['onReceive'])){
            ($this->funcType['onReceive'])($this,$client,$data);
        }

        if(is_callable($this->funcType['onSend'])){
            ($this->funcType['onSend'])($this,$client);
        }



    }

}