#!/bin/bash
function testCurl()
{
    php /data/www/learnNote/io_model/phpDemo/index_client.php &
}


for((i=0;i<40;i++));
do
    testCurl;
done