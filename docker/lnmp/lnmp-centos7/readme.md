##本人维护的第一个lnmp

	非实例容器的时候启动，实例化之后需要进入/root/lnmp/进行脚本启动或者关闭

##win机器实例化容器

    docker run -itd --name lnmp -v /e:/data/www -p 8080:80 --network=mynet --ip 8.8.8.2  niushaogang/lnmp-centos7:v1.0.0