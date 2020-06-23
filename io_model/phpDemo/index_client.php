<?php

require_once "./base.php";



switch ($handle) {
    case 'blocking':
        # code...
            $clientObj = new \client\blocking_client($config['host']['client_host']);
        break;

    case 'non_blocking':
        # code...
            $clientObj = new \client\non_blocking_client($config['host']['client_host']);
        break;

    case 'multiplex':
        # code...
            $clientObj = new \client\multiplex_client($config['host']['client_host']);
        break;

    case 'signal':
        # code...
            $clientObj = new \client\signal_client($config['host']['client_host']);
        break;

    case 'async':
        # code...
            $clientObj = new \client\async_client($config['host']['client_host']);
        break;

    default:
        # code...
        break;
}

$clientObj->main();