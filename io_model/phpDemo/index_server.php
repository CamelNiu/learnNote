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

    case 'multiplex':
        # code...
            $serverObj = new \server\multiplex_server($config['host']['server_host']);
        break;

    case 'signal':
        # code...
            $serverObj = new \server\signal_server($config['host']['server_host']);
        break;

    default:
        # code...
        break;
}

$serverObj->main();