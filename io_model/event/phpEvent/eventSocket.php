<?php
use \Event as Event;
use \EventBase as EventBase;
require "./base.php";
require "./execEvent.php";


$socketHost = "tcp://127.0.0.1:8080";
$server = stream_socket_server($socketHost);
echo $socketHost."\n";

$eventBase = new EventBase();

$count = [];

$event = new Event($eventBase,$server,Event::PERSIST | Event::READ | Event::WRITE ,function($socket)use($eventBase,&$count){
    echo "connect before\n";
    $client = stream_socket_accept($socket);
    echo "connect after\n";

    (new execEvent($eventBase,$client,$count))->handler();




});

$event->add();
$eventBase->loop();



