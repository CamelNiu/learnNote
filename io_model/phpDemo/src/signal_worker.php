<?php
namespace src;

class signal_worker extends common_worker
{

    public function __construct($host)
    {
        parent::__construct($host);
        echo "[SERVER] signal server \n";
    }

    public function accept()
    {

        while (true) {
            $client = stream_socket_accept($this->socket);
            echo "[SERVER] connect is success \n";
            pcntl_signal(SIGIO,$this->sigHander($client));
            posix_kill(posix_getpid(),SIGIO);
            echo "[SERVER] signal is not dispatch \n";//服务器注册信号之后可以做别的事，比如执行这句代码，等到分发信号再执行，代码可以非阻塞
            //分发
            pcntl_signal_dispatch();
        }

    }

    public function sigHander($client)
    {
        return function()use($client){
            $data = fread($client,65535);

            if(is_callable($this->funcType['onReceive'])){
                ($this->funcType['onReceive'])($this,$client,$data);
            }

            if(is_callable($this->funcType['onSend'])){
                ($this->funcType['onSend'])($this,$client);
            }

            fclose($client);
        };
    }

}