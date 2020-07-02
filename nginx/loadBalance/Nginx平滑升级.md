## Nginx平滑升级

#####1，说明

	这两天在研究nginx动态负载均衡,需要用到第三方模块，不过之前没有装。卸载重装Nginx又太麻烦，查询资料得知
	nginx可以进行平滑升级。就用了平滑升级安装了nginx-upsync-module。由于之前不知道这个知识点，自己搞完打
	算写个总结，分享出来，一来当作自己的笔记，二来有需要的朋友也可以参考

#####2，概览

	当已经安装了nginx,只需要升级新版本或者加模块的情况下，我们需要平滑升级。如果当前没有安装nginx,安装参数
	配置进去进行安装就可以了。
		有两种方案：
			1，条件允许的情况下，卸载nginx重装。
			2，在nginx运行中，进行平滑升级或者安装模块。
	本文着重记录下第二种方案的执行过程。

#####3,操作过程
	1，查看当前已安装nginx的配置参数
		
		/usr/local/nginx/sbin/nginx -V

		例如：
			#执行命令
			#已安装配置参数 即--prefix=/usr/local/nginx
			[root@4598d101709d ~]# /usr/local/nginx/sbin/nginx -V	
			nginx version: nginx/1.18.0
			built by gcc 4.8.5 20150623 (Red Hat 4.8.5-39) (GCC)
			configure arguments: --prefix=/usr/local/nginx			
		

	2，进入nginx源码包目录(没有的话自行下载源码包,下载的版本即是当前操作后的版本)

		1，参数配置简介：
			执行./configure --help可查看所有参数配置以及相关的自带模块
				自带模块
				   --with-http_geoip_module      安装的时候加某个模块
				   --without-http_charset_module  安装的时候不要某个模块
				第三方模块
				   --add-module=/nginxModule/loadBalance/nginx-upsync-module-2.1.0 
				   后面跟第三方模块的绝对路径

		2，注意：
			./configure --XXX执行的时候，一定要把之前安装的配置参数带进去，要不然第二次安装的
			参数配置会覆盖第一次安装的

		3，执行
			./configure --XXX

			例如：
				./configure \
				--prefix=/usr/local/nginx \										  #之前的配置
				--add-module=/nginxModule/loadBalance/nginx-upsync-module-2.1.0 \ #要加入的第三方模块
				--with-mail=dynamic \											  #要安装的自带模块

		4，执行make进行编译
			注意：不能执行make install，要不然就会直接赴覆盖安装

		5，复制二进制文件
			make编译之后,在当前目录的objs目录里生成nginx二进制执行文件。将原先的nginx执行文件做备份，然后
			把新的二进制文件拷贝到之前的安装目录，也就是/usr/local/nginx/sbin/中

		6，在nginx源码包目录执行 make upgrade升级
			用 /usr/local/nginx/sbin/nginx -V 命令查看新的版本或者参数配置，如果成功，则升级成功
			需要注意的是，执行过程中有可能会抛出异常，因为执行过程中会有些文件不存在什么的，不用管他。