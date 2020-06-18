<?php

require_once "./base.php";
$clientHost = $hostConfig['client'];
$clientSocket = stream_socket_client($clientHost);
echo "[CLIENT] client connect success [".$clientHost."]\n";

fwrite($clientSocket,"[CLIENT] this message is client send to server");

$serverMsg = fread($clientSocket,65535);
echo $serverMsg.PHP_EOL;
fclose($clientSocket);