<?php
//非阻塞socket,worker实例
namespace src;

class non_blocking_worker extends common_worker
{
    public function __construct($host)
    {
        parent::__construct($host);
    }




}