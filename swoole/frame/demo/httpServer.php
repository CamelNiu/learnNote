<?php

use Swoole\Http\Server;

$http = new Server("0.0.0.0",80);
$http->on('request', function ($request, $response) {
    $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
});


$http->on('managerStart',function(){
    var_dump('abc');
});

$http->on('managerStop',function(){
    var_dump('niushaogang');
});

echo "http server demo \n";
$http->start();