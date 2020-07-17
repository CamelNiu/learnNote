<?php

// error_reporting(E_ALL ^ E_NOTICE);

// error_reporting(E_ALL ^ E_WARNING);



$config = [
    "host" => [
        'server_host' => "tcp://127.0.0.1:8080",
        'client_host' => "tcp://127.0.0.1:8080",
    ],
];

$handle = "reactor";
//$handle = "blocking";