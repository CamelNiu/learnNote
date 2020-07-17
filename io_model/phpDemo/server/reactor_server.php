<?php
namespace server;
/**
 *
 */
use Swoole\Event;
class reactor_server
{
    public $server;
    public $client;
    public $processNum = 2;
    public $host;
    public $workerPids = [];

    public function __construct($host)
    {
        $this->host = $host;
    }

    public function initServer()
    {
        // 并不会起到太大的影响
        // 这里是参考与workerman中的写法
        $opts = [
            'socket' => [
                // 设置等待资源的个数
                'backlog' => '102400',
            ],
        ];

        $context = stream_context_create($opts);
        // 设置端口可以重复监听
        \stream_context_set_option($context, 'socket', 'so_reuseport', 1);

        // 传递一个资源的文本 context
        return $this->server = stream_socket_server($this->host , $errno , $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, $context);
    }


    public function accept()
    {
        Event::add($this->initServer(),$this->execAccept());
    }

    public function execAccept()
    {
        return function(){
            $client = stream_socket_accept($this->server);
            $pid = posix_getpid();
            echo "[SERVER] connect success ".$pid." \n";
            Event::add($client,$this->execTask($client));
        };
    }

    public function execTask($socket)
    {
        return function($socket){

            $data = \fread($socket,65535);

            $pid = posix_getpid();

            //require ROOT_PATH."/server/reactor_msg.php";


            fwrite($socket,"[SERVER] server to client pid ".$pid." \n",65535);
            echo $data;
            if(empty($data)){
                if(feof($socket) || !is_resource($socket)){
                    //触发关闭事件
                    swoole_event_del($socket);
                    fclose($socket);
                }
            }

        };
    }

    public function multiProcess()
    {

        for ($i=0; $i <$this->processNum ; $i++) {
            $res = pcntl_fork();
            if($res > 0){
                $this->workerPids[] = $res;
                var_dump($res);
            }elseif($res <0 ){
                throw new \Exception("Error Processing Request", 1);
            }else{
                $this->accept();
                break;
            }
        }

        for ($i=0; $i < $this->processNum; $i++) {
            $status = 0;
            $son = pcntl_wait($status);
        }

    }

    public function main()
    {
        $this->multiProcess();

    }

}