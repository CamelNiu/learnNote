## lnmp

	hub地址：
	https://hub.docker.com/repository/docker/niushaogang/lnmp-centos7

------------------------------------------------------
####version x.x.x

1.versionCode

2.plan

3.describe

4.finish

------------------------------------------------------

####V1-V10[finished]
1.V1-V10

	niushaogang/lnmp-centos7:v1-niushaogang/lnmp-centos7:v10

	刚开始用v1-v10的方式维护。V10后启动vx.x.x进行版本维护
	v1.0.0为v10后的第一个版本。

2.plan

	实现基本的lnmp

3.describe

	实现基本的lnmp，redis，python3

	lnmp不是容器启动，需要实例化容器之后手动启动
	cd /root/lnmp/目录，里面有启动脚本，停止脚本。
	python3调用直接用python3,因为python2涉及yum等脚本，没有改动

------------------------------------------------------

####v1.0.0[finished]
1.v1.0.0

	camelniu/lnmp-centos7:v1.0.0
2.plan

	1,nginx实现pathinfo模式
	2,nginx平滑升级安装模块nginx-upsync-module(动态负载均衡)
	3,nginx平滑升级安装模块ngx_cache_purge(nginx删除缓存)

3.describe

	1,nginx实现pathinfo模式
	2,nginx平滑升级安装模块nginx-upsync-module(动态负载均衡)
	3,nginx平滑升级安装模块ngx_cache_purge(nginx删除缓存)
	4,php根目录index.html,index.php修改内容，以前是调试内容，现在是欢迎语



####v1.1.0[finished]
1.v1.1.0

	camelniu/lnmp-centos7:v1.1.0

2.plan

	1,系统时区，php时区
	2,安装composer
	3,安装yaf，yar
	4,安装go语言运行环境

3.describe

	1,系统时区，php时区
	2,安装composer
	3,安装yaf，yar
	4,安装go语言运行环境


####v1.1.1[plan]
1.v1.1.1

	camelniu/lnmp-centos7:v1.1.1

2.plan

	1,优化start,stop,restart脚本
    2,mysql数据库，加新用户niushao
    3,优化phpfpm，nginx进程
    4,安装seaslog扩展
    
3.describe

	1,优化start,stop,restart脚本
    2,mysql数据库，加新用户niushao
    3,优化phpfpm，nginx进程
    4,安装seaslog扩展



