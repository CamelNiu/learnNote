<?php
include __DIR__."/vendor/autoload.php";

$ioType = 'blocking';

$testObj = null;

switch ($ioType) {
    case 'blocking':

            $testObj = new \client\blocking\client();

        break;

    default:
        # code...
        break;
}


$testObj->main();