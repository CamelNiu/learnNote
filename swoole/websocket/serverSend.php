<?php
require "./config.php";
require "./db.php";
$db = new DatabaseOperate();

use Swoole\WebSocket\Server as wsServer;

/**
 *
 */
class serverSend
{

    private $config;
    private $host;
    private $port;
    private $ws;
    private $db;
    private $event = [
        'open' => "onOpen",
        'connect' => "onConnect",
        'message' => "onMessage",
        'close' => "onClose",
    ];

    function __construct($config,$db)
    {
        $this->db = $db;
        $this->config = $config;
        $this->init();
        $this->registerEvent();
    }


    private function init()
    {
        $this->host = $this->config['ws']['host'];
        $this->port = $this->config['ws']['port'];
        $this->ws = new wsServer($this->host,$this->port);
    }

    private function registerEvent()
    {
        foreach($this->event as $key => $val){
            $this->ws->on($key,[$this,$val]);
        }
    }

    public function onOpen(wsServer $server,$request)
    {
        $this->ws->push($request->fd, "Server:connect success\n");
        $this->pushTotal($request);

    }

    private function getFds()
    {
        $fds = $this->ws->getClientList();
        return $fds;
    }

    private function pushTotal()
    {
        $resArr = [];
        while (true) {

            $fds = $this->getFds();

            if(count($resArr)>=6){
                $resArr = [];
            }

            if(!$fds) continue;


            $total = $this->getLogData();
            var_dump($total);
            $data = [
                'type'  => 'log_num',
                'total' => $total,
            ];



            foreach($fds as $key => $val){
                if($this->ws->exists($val)){
                    $res = $this->ws->push($val,json_encode($data));
                    $resArr[] = $res;
                    var_dump($resArr);
                    if( count(array_unique($resArr)) == 1 && $resArr[0] == false ){
                        $this->ws->close($val);
                    }
                }
            }

            sleep(2);
        }
    }

    private function getLogData()
    {
        $sql = "select count(*) as total from ns_visit_log";
        $count = $this->db->getAllArray($sql);
        $total = $count[0]['total'];
        //$total = mt_rand(100,10000);
        return $total;
    }

    public function onConnect(wsServer $server, int $fd, int $reactorId)
    {

    }

    public function onMessage(wsServer $server, $frame)
    {

    }

    public function onClose(wsServer $server, $fd)
    {
        echo "连接断开 \n";
    }

    public function start()
    {
        $this->ws->start();
    }

}






$ser = new serverSend($config,$db);
$ser->start();





// $ws = new Swoole\WebSocket\Server($config['ws']['host'],$config['ws']['port']);


// $ws->on('open',function($ws,$request){
//     $ws->push($request->fd, "Server:connect success\n");
//     $fds = $ws->getClientList();
//     go(function () use($fds,$ws) {
//         while (true) {
//             foreach ($fds as $key => $fd) {
//                 if ($ws->exists($fd)) {
//                     $ws->push($fd, 'connect success');
//                 }
//             }
//             usleep(1000000);
//         }
//     });
// });

// $ws->on('connect',function(Swoole\Server $ws, int $fd, int $reactorId){
//     // $fds = $ws->getClientList();
//     // while (true) {
//     //     var_dump(count($fds));
//     //     sleep(2);
//     // }
// });

// //监听WebSocket消息事件
// $ws->on('message', function ($ws, $frame) {
//     $msg = $frame->data;
//     $fds = $ws->getClientList();
//     // while (true) {
//     //     foreach ($fds as $key => $fd) {
//     //         if ($ws->exists($fd)) {
//     //             $ws->push($fd, '123');
//     //         }
//     //     }
//     //     sleep(1);
//     // }
//     foreach ($fds as $key => $fd) {
//         if ($ws->exists($fd)) {
//             $ws->push($fd, $msg);
//         }
//     }
// });

// //监听WebSocket连接关闭事件
// $ws->on('close', function ($ws, $fd) {
//     echo "client-{$fd} is closed\n";
// });

// $ws->start();