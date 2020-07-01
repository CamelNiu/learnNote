<?php

    function getServerIp(){
        exec('ifconfig',$ipInfo);
        $reg = "/inet (8.8.8.\d)/";
        $ip = "";
        foreach($ipInfo as $val){
            $res = preg_match($reg,$val,$matchs);
            if($res){
                $ip = $matchs[1];
                return $ip;
                break;
            }
        }
        return $ip;
    }

    $ip = getServerIp();

    //高性能HTTP服务器
    $http = new Swoole\Http\Server("0.0.0.0", 9001);

    $http->on("start", function ($server) use($ip) {
        echo "Swoole http server is started at http://".$ip.":9001\n";
    });

    $http->on("request", function  ($request, $response)use($ip) {
        $response->header("Content-Type", "text/plain");
        $response->end("Hello World ".$ip."\n");
    });

    $http->start();