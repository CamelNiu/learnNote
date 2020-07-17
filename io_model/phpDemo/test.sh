#!/bin/bash
start=`date +"%s.%N"`
function testCurl()
{
    php /data/www/learnNote/io_model/phpDemo/index_client.php &
}


for((i=0;i<50000000;i++));
do
    testCurl;
done

wait

end=`date +"%s.%N"`

c=`echo "$end - $start"|bc`

echo $c