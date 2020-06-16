<?php
include __DIR__."/vendor/autoload.php";

$ioType = 'blocking';

$testObj = null;

switch ($ioType) {
    case 'blocking':

            $testObj = new \app\blocking\server();

        break;

    default:
        # code...
        break;
}


$testObj->main();