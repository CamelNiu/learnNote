<?php

function getSocketAddress($protocol,$ip,$port)
{
    $socketAddress = $protocol."://".$ip.":".$port;
    return $socketAddress;
}