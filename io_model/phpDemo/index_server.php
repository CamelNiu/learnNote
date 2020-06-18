<?php

require_once "./base.php";



switch ($handle) {
    case 'blocking':
        # code...
            $serverObj = new \server\blocking_server($config['host']['server_host']);
        break;

    case 'non_blocking':
        # code...
            $serverObj = new \server\non_blocking_server($config['host']['server_host']);
        break;

    default:
        # code...
        break;
}

$serverObj->main();