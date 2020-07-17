#!/bin/bash
handle=$1
if [ ! $1 ];
then
  handle="start"
else
  handle=$1
fi

#function kill process
function killProcess()
{
    res=`ps -aux | grep -v 'grep' | grep $1 | awk '{print $2}'`

    for i in $res
    do
	`kill -9 $i`
    done
}

function writeLog()
{

    if [ ! -w "/root/redis/logs/redis_init.log" ];then
        `mkdir -p /root/redis/logs/`
        `touch /root/redis/logs/redis_init.log`
    fi

    time=`date "+%Y-%m-%d %H:%M:%S"`
    echo [$time][$1] >> /root/redis/logs/redis_init.log

}



case $handle in
"start")
    /usr/local/redis-5.0.8/bin/redis-server /data/www/redis_cluster/conf/conf14/redis.conf &
    writeLog $handle
;;
"stop")
    /usr/local/redis-5.0.8/bin/redis-cli shutdown
    #killProcess redis
    writeLog $handle
;;
"restart")
    /usr/local/redis-5.0.8/bin/redis-cli shutdown
    #killProcess redis
    /usr/local/redis-5.0.8/bin/redis-server /data/www/redis_cluster/conf/conf14/redis.conf &
    writeLog $handle
;;
*)
   writeLog  "Param Error. param must be (start,stop,restart). You Input:$handle"
;;
esac
