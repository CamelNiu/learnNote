#!/bin/bash

function curltest()
{
    curl "127.0.0.1:9001";
}

for((i=1;i<=10;i++));
do
    curltest;
done