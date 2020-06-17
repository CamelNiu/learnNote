<?php
include __DIR__."/vendor/autoload.php";
include __DIR__."/base.php";

$ioType = 'multiplex';

$testObj = null;

switch ($ioType) {
    case 'blocking':

            $testObj = new \server\blocking\server();

        break;

    case 'non_blocking':

            $testObj = new \server\non_blocking\server();

        break;

    case 'multiplex':

            $testObj = new \server\multiplex\server();

        break;


    default:
        # code...
        break;
}


$testObj->main();