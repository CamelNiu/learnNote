<?php
//初始化公共文件，定义一些设置，全局常量等
ini_set('date.timezone','Asia/Shanghai');

//配置
$hostConfig = [
    'server' => "tcp://127.0.0.1:9001",
    'client' => "tcp://127.0.0.1:9001",
];

//$socketAddress = $config['server']['protocol']."://".$config['server']['ip'].":".$config['server']['port'];



// //公共函数,拼接socket地址
// function getSocketAddress()
// {
//     $socketAddress = $config[$handle]['protocol']."://".$config[$handle]['ip'].":".$config[$handle]['port'];
// }

// getSocketAddress('server');