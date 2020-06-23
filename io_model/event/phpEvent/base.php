<?php



$exec = function($client)
{
    $data = fread($client,65535);
    var_dump($data);
    fwrite($client,"hello word \n");
    fclose($client);
};