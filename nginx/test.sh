#!/bin/bash
function testCurl()
{
    curl 8.8.8.2:80/demo.php &
}

function balanceTest()
{
    curl 8.8.8.2 &
}

for((i=0;i<200;i++));
do
    balanceTest;
done