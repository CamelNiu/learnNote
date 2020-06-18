<?php
//阻塞socket,worker实例
namespace src;

class blocking_worker extends common_worker
{
    public function __construct($host)
    {
        parent::__construct($host);
    }




}