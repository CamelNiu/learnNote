<?php
// 同步客户端
// copy
$client = new swoole_client(SWOOLE_SOCK_TCP | SWOOLE_KEEP);

//连接到服务器
if (!$client->connect('127.0.0.1', 9501, 0.5))
{
    die("connect failed.");
}
// $len = pack('N', strlen($i));
// $send = $len.$i;
// $client->send($send);

// for ($i=0; $i < 100; $i++) {
    $len = pack('N', strlen('abc'));
    var_dump($len);
    die();
    $send = $len;
    $client->send($send);
// }


sleep(10);
// $client->send(1);
//从服务器接收数据
$data = $client->recv();
//关闭连接
// $client->close();

// 另一个事情
// 返回结果给用户
echo '订单生成成功'."\n";
