#!/bin/bash

res=`ps -aux | grep -v 'grep' | grep processDemo | awk  '{print $2}'`
    for i in $res
    do
        `kill -9 $i`
    done

