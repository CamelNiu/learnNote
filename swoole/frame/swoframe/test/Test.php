<?php

require __DIR__."/../vendor/autoload.php";

use \src\Index;
use \app\App;

echo (new Index())->index()."\n";
echo (new App())->index()."\n";