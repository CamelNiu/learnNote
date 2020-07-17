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

    case 'multi_process':
        # code...
            $clientObj = new \client\multi_process_client($config['host']['client_host']);
        break;

    case 'reactor':
        # code...
            $clientObj = new \client\reactor_client($config['host']['client_host']);
        break;

    default:
        # code...
        break;
}

$clientObj->main();