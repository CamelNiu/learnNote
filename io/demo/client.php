<?php
include __DIR__."/vendor/autoload.php";
include __DIR__."/base.php";

$ioType = 'multiplex';

$testObj = null;

switch ($ioType) {
    case 'blocking':

            $testObj = new \client\blocking\client();

        break;

    case 'non_blocking':

            $testObj = new \client\non_blocking\client();

        break;

    case 'multiplex':

            $testObj = new \client\multiplex\client();

        break;

    default:
        # code...
        break;
}


$testObj->main();