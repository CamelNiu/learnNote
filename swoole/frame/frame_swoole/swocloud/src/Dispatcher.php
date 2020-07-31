<?php
namespace SwoCloud;

use Redis;
use Swoole\Server as SwooleServer;

class Dispatcher
{
    public function register(Route $route,SwooleServer $server, $fd, $data)
    {
        dd('register', 'Dispatcher');

        $serverKey = $route->getServerKey();
        // 把服务端的信息记录到redis中
        $redis = $route->getRedis();
        $value = \json_encode([
            'ip'   => $data['ip'],
            'port' => $data['port'],
        ]);
        $redis->sadd($serverKey, $value);
        // 这里是通过触发定时判断，不用heartbeat_check_interval 的方式检测
        // 是因为我们还需要主动清空，redis 数据
        //
        // $timer_id 定时器id
        $server->tick(3000, function($timer_id, Redis $redis,SwooleServer $server, $serverKey, $fd, $value){
            // 判断服务器是否正常运行，如果不是就主动清空
            // 并把信息从redis中移除
            if (!$server->exist($fd)) {
                $redis->srem($serverKey, $value);
                $server->clearTimer($timer_id);

                dd('im server 宕机， 主动清空');
            }
        }, $redis, $server, $serverKey, $fd, $value);
    }
}
