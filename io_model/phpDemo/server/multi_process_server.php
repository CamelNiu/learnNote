<?php
namespace server;
/**
 *
 */
class multi_process_server
{
    public $server;
    public $host;
    public $processNum = 2;
    public function __construct($host)
    {
        $this->host = $host;
        $this->server = stream_socket_server($this->host);
        stream_set_blocking($this->server, 0);
    }

    public function accept()
    {

        while (true) {
            $client = stream_socket_accept($this->server);
            echo "[SERVER] connect is success \n";
            //获取数据
            $data = fread($client,65535);
            echo $data."\n";
            $pid = posix_getpid();
            //写入数据
            fwrite($client,"[SERVER] server to client pid ".$pid." \n",65535);
            fclose($client);
        }

    }

    public function multiProcess()
    {
        for ($i=0; $i <$this->processNum ; $i++) {
            $res = pcntl_fork();
            if($res > 0){

            }elseif($res <0 ){
                throw new \Exception("Error Processing Request", 1);
            }else{
                //$pid = posix_getpid();
                $this->accept();

            }
        }

        for ($i=0; $i < $this->processNum; $i++) {
            $status = 0;
            $son = pcntl_wait($status);
        }

        //$this->accept();

    }

    public function main()
    {
        $this->multiProcess();
    }

}