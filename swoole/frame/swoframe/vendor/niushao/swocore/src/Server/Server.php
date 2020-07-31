<?php
namespace src\Server;

use Swoole\Server as SwooleServer;

abstract class Server
{
    protected $swooleServer;
    protected $app;
    protected $inotify = null;
    protected $watchFile = false;
    protected $serverType = "TCP";
    protected $port       = "80";
    protected $host       = "0.0.0.0";
    protected $config = [
        'task_worker_num' => 0,
    ];

    /**
     * [$pidMap id信息]
     * @var [arr]
     */
    protected $pidMap = [
        'masterPid'  => 0,
        'managerPid' => 0,
        'workerPids' => [],
        'taskPids'   => []
    ];

    /**
     * [$event 回调事件]
     * @var [array]
     */
    protected $event = [
        // 这是所有服务均会注册的时间
        "server" => [
            // 事件   =》 事件函数
            "start"        => "onStart",
            "managerStart" => "onManagerStart",
            "managerStop"  => "onManagerStop",
            "shutdown"     => "onShutdown",
            "workerStart"  => "onWorkerStart",
            "workerStop"   => "onWorkerStop",
            "workerError"  => "onWorkerError",
        ],
        // 子类的服务
        "sub" => [],
        // 额外扩展的回调函数
        // 如 ontart等
        "ext" => []
    ];

    /**
     * [__construct description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-22T17:34:37+0800]
     * @param    Application                $app                [description]
     */
    public function __construct($app)
    {
        $this->app = $app;
    }
    /**
     * [onStart description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:32:04+0800]
     * @param    SwooleServer               $server             [description]
     * @return   [type]                                         [description]
     */
    public function onStart(SwooleServer $server)
    {

        $this->pidMap['masterPid'] = $server->master_pid;
        $this->pidMap['managerPid'] = $server->manager_pid;
        if ($this->watchFile ) {
            $this->inotify = new Inotify($this->app->getBasePath(), $this->watchEvent());
            $this->inotify->start();
        }
    }
    /**
     * [onManagerStart description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:31:16+0800]
     * @param    SwooleServer               $server             [description]
     * @return   [type]                                         [description]
     */
    public function onManagerStart(SwooleServer $server)
    {

    }

    /**
     * [onManagerStop description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:31:20+0800]
     * @param    SwooleServer               $server             [description]
     * @return   [type]                                         [description]
     */
    public function onManagerStop(SwooleServer $server)
    {

    }

    /**
     * [onShutdown description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:31:23+0800]
     * @param    SwooleServer               $server             [description]
     * @return   [type]                                         [description]
     */
    public function onShutdown(SwooleServer $server)
    {

    }

    /**
     * [onWorkerStart description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:33:08+0800]
     * @param    SwooleServer               $server             [description]
     * @param    int                        $worker_id          [description]
     * @return   [type]                                         [description]
     */
    public function onWorkerStart(SwooleServer $server,int $worker_id)
    {
        $this->pidMap['workerPids'] = [
            'id' => $worker_id,
            'pid'=> $server->worker_id,
        ];
    }


    /**
     * [onWorkerStop description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:31:33+0800]
     * @param    SwooleServer               $server             [description]
     * @return   [type]                                         [description]
     */
    public function onWorkerStop(SwooleServer $server)
    {

    }

    /**
     * [onWorkerError description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:31:37+0800]
     * @param    SwooleServer               $server             [description]
     * @return   [type]                                         [description]
     */
    public function onWorkerError(SwooleServer $server)
    {

    }




    /**
     * [createServer description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-22T17:34:28+0800]
     * @return   [type]                     [description]
     */
    protected abstract function createServer();

    /**
     * [initEvent description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-22T17:34:32+0800]
     * @return   [type]                     [description]
     */
    protected abstract function initEvent();

    /**
     * [start description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:31:49+0800]
     * @return   [type]                     [description]
     */
    public function start()
    {
        $this->createServer();
        $this->swooleServer->set($this->config);

        $this->initEvent();

        $this->setSwooleEvent();

        $this->swooleServer->start();
    }

    /**
     * [setSwooleEvent description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:31:54+0800]
     */
    protected function setSwooleEvent()
    {

        foreach($this->event as $type => $events){
            foreach($events as $event => $func){
                $this->swooleServer->on($event,[$this,$func]);
            }
        }

        // foreach ($this->event as $type => $events) {
        //     foreach ($events as $event => $func) {
        //         $this->swooleServer->on($event, [$this, $func]);
        //     }
        // }

    }

    /**
     * [watchEvent description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:31:58+0800]
     * @return   [type]                     [description]
     */
    protected function watchEvent()
    {
        return function($event){
            // $action = 'file:';
            // switch ($event['mask']) {
            //     case IN_CREATE:
            //       $action = 'IN_CREATE';
            //       break;
            //     case IN_DELETE:
            //       $action = 'IN_DELETE';
            //       break;
            //     case \IN_MODIFY:
            //       $action = 'IN_MODIF';
            //       break;
            //     case \IN_MOVE:
            //       $action = 'IN_MOVE';
            //       break;
            // }
            // echo "因为什么重启";
            $this->swooleServer->reload();
        };
    }





    /**
     * [setEvent description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-22T17:41:20+0800]
     * @param    [type]                     $type               [description]
     * @param    [type]                     $event              [description]
     */
    public function setEvent($type,$event)
    {
        if( $type == 'server' ){
            return $this;
        }
        $this->event[$type] = $event;
        return $this;
    }

    /**
     * [getConfig description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:32:13+0800]
     * @return   [type]                     [description]
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * [setConfig description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:32:16+0800]
     */
    public function setConfig()
    {
        $this->config = array_map($this->config,$config);
        return $this;
    }

    /**
     * [watchFile description]
     * @Author   [NiuShao                   <camel_niu@163.com> <qq:370574131>]
     * @DateTime [2020-07-23T10:32:20+0800]
     * @param    [type]                     $watchFile          [description]
     * @return   [type]                                         [description]
     */
    public function watchFile($watchFile)
    {
        $this->watchFile = $watchFile;
    }




}
