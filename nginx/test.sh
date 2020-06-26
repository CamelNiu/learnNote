#!/bin/bash
function testCurl()
{
    curl 8.8.8.2:80/demo.php &
}


for((i=0;i<10;i++));
do
    testCurl;
done