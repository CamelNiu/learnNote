<?php
$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);
$key = "key1";
$redis->lPush($key, 'hello 我是 shineyork');
$redis->lPush($key, 'hello 我是 sixstar');
