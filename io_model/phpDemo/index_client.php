<?php

require_once "./base.php";



switch ($handle) {
    case 'blocking':
        # code...
            $serverObj = new \client\blocking_client($config['host']['client_host']);
        break;

    case 'non_blocking':
        # code...
            $serverObj = new \client\non_blocking_client($config['host']['client_host']);
        break;

    default:
        # code...
        break;
}

$serverObj->main();