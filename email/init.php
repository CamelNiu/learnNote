<?php

header("Content-type:text/html;charset=utf-8");

define('__ROOT_PATH__',dirname(__FILE__));

require __ROOT_PATH__."/vendor/autoload.php";

require __ROOT_PATH__."/email/email.php";
require __ROOT_PATH__."/curl/curl.php";
require __ROOT_PATH__."/log/log.php";
