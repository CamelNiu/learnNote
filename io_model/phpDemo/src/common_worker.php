<?php
namespace src;

class common_worker
{
    protected $socket;
    protected $host;

    protected $funcType = [
        'onReceive' => null,
        'onSend'    => null,
        'onClose'   => null,
    ];

    protected function __construct($host)
    {
        $this->host = $host;
        $this->socket = stream_socket_server($this->host);
        echo "[SERVER] ".$this->host." server created \n";

    }

    //接收连接
    public function accept()
    {
        while (true) {
            $client = stream_socket_accept($this->socket);

            echo "[SERVER] connect is success \n";

            $data = fread($client,65535);

            if(is_callable($this->funcType['onReceive'])){
                ($this->funcType['onReceive'])($this,$client,$data);
            }

            if(is_callable($this->funcType['onSend'])){
                ($this->funcType['onSend'])($this,$client);
            }

            fclose($client);
        }

    }

    //绑定事件函数
    public function on($type,$func)
    {
        if(!in_array($type,array_keys($this->funcType))) throw new Exception("当前方法不可绑定",-1);
        $this->funcType[$type] = $func;
    }

    public function send($conn,$data)
    {
        fwrite($conn,$data,65535);
    }

    public function start()
    {
        $this->accept();
    }

}