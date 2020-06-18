<?php

require_once "./base.php";

//创建一个socket
$serverHost = $hostConfig['server'];
$serverSocket = stream_socket_server($serverHost);
echo "[SERVER] server create success [".$serverHost."]\n";

//设置为非阻塞
stream_set_blocking($serverSocket,0);


$readSocket[(int)$serverSocket ] = $serverSocket;



//轮询机制不断监听客户端过来的连接,没有连接则serverSocket阻塞
while(true){

    $read = $readSocket;

    stream_select($read,$write,$except,1);

    var_dump($read);

    foreach($read as $val){
        if($val === $serverSocket){
            //创建连接
            $clientSocket = stream_socket_accept($serverSocket);
            //fwrite($clientSocket,'[SERVER] connect success');
            $readSocket[(int)$clientSocket] = $clientSocket;

        }else{
            //发送信息
            $clientMsg = fread($val,65535);
            echo $clientMsg.PHP_EOL;
            sleep(5);
            fwrite($val,"[SERVER] this msg is server send to client");

            fclose($val);
            unset($readSocket[(int)$val]);
        }
    }

    usleep(500000);

    // $connSocket = stream_socket_accept($serverSocket);

    // $startTime = microtime(true);

    // $clientMsg = fread($connSocket,65535);
    // echo $clientMsg.PHP_EOL;

    // task();

    // $endTime = microtime(true);

    // fwrite($connSocket,'[SERVER] task finish. time['.($endTime-$startTime).']');

    // fclose($connSocket);
}



function task()
{
    sleep(5);
}