#!/bin/bash
start=`date +"%s.%N"`
function testCurl()
{
    curl http://127.0.0.1/www/DH_TuoLing/item/public/index.php/api/ipinfo?ip=172.104.88.48 &
}


for((i=0;i<5000;i++));
do
    testCurl;
done

wait

end=`date +"%s.%N"`

c=`echo "$end - $start"|bc`

echo $c