#!/bin/bash
\cp /data/www/nginx.conf /usr/local/nginx/conf/nginx.conf
/root/lnmp/stoplnmp.sh
/root/lnmp/initlnmp.sh