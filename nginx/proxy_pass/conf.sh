#!/bin/bash
rm -rf /usr/local/nginx/conf/vhosts;
cp -r /data/www/learnNote/nginx/proxy_pass/vhosts/ /usr/local/nginx/conf/vhosts/;
/root/lnmp/stoplnmp.sh;
/root/lnmp/initlnmp.sh;