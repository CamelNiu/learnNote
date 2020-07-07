## Nginx缓存

##### 1，缓存简介

	一个web项目,从服务器到客户端，主要在三个地方着手设计缓存。
		1，服务器缓存，一般使用redis,memcache，file等等，缓存一些热点数据之类的。
		2，代理服务器缓存，比如nginx缓存，对一些静态资源可以不用请求后端服务器,直接nginx缓存返回。
		3，客户端缓存，比如浏览器缓存。

	    其中第一个，服务器缓存是后端开发人员涉及最多的，设计合理的缓存对整个项目相当重要。代理服务
	器缓存的话，后端开发人员也是需要懂的，对项目优化部署也很重要。客户端缓存的话，比如基于浏览器缓
	存，主要是前端app开发人员涉及较多，后端开发涉及较少。
		博主最近深入研究nginx，本文主要探讨下代理服务器缓存中，nginx缓存的细节问题。



#####  2，nginx缓存

1,模块
	
	ngx_http_proxy_module 模块来设置nginx的代理服务器缓存

	详细文档：·http://tengine.taobao.org/nginx_docs/cn/docs/http/ngx_http_proxy_module.html

2，常用配置

	1，proxy_cache_path 

		用途：设置一个缓存目录，其文件名是cache_key的md5值。
		语法：proxy_cache_path[levels=number] keys_zone=zone_name:zone_size[inactve=time] [max_size=size];
		上下文：http{}
		参数：
			levels=1:2			    定义缓存层次结构
			keys_zone=Name:size		定义共享内存，存放键和缓存数据相关信息。
			inactve=time		    缓存没有被访问的过期时间，默认10min
			max_size=size			缓存最大容量
		实例：
			proxy_cache_path /root/nginx/cache levels=1:2 keys_zone=test:1m
 
	-----------------------------------------------------------------------

	2,proxy_cache
		用途：指定上文http设置的缓存。比如上文可以设置多个，此命令指定使用哪一个，用keys_zone的name指定
		语法：proxy_cache zone | off
		上下文：http,server,location
		参数：
			zone,上文设置的缓存名称
			off,屏蔽从上层配置的缓存功能
		实例：
			proxy_cache test;

	-----------------------------------------------------------------------

	3,proxy_cache_valid	

		用途：为不同的响应状态码设置不同的缓存时间
		语法：proxy_cache_valid [code ...] time;
		上下文:	http, server, location
		实例：
			proxy_cache_valid 200 1m;
			proxy_cache_valid 404 1m;
			proxy_cache_valid any 1m;//表示所有的返回都缓存。m是分钟的意思
	
	
	实例：

		http{
			……
			//定义一个缓存
			proxy_cache_path /root/nginx/cache levels=1:2 keys_zone=test:1m max_size=2m;
			……
			server{
				……
				location / {
					//指定用哪个共享内存
		            proxy_cache test; 
					//配置缓存时长           
					proxy_cache_valid any 1m;
					//代理地址，会将返回的数据存入缓存中
					proxy_pass http://remote.address;
				}
				……
			}
		}

4归纳：
	
	1，用上述配置，就完成了最简单的nginx缓存。对，很简单。只需要一下三项配置
		(1)，proxy_cache_path
		(2)，proxy_cache
		(3)，proxy_cache_valid

	2,需要注意的是开启缓存之后，nginx会多一个缓存维护进程
		nginx: cache manager process


	说明：
	这仅仅是nginx缓存最基本的操作，另外还有很多非必须配置项用以优化缓存配置，可自行查阅
	淘宝团队翻译的nginx文档。

	地址：
	http://tengine.taobao.org/nginx_docs/cn/docs/http/ngx_http_proxy_module.html

##### 3，清除缓存

1，粗暴实现：

	nginx清除缓存，最粗暴的方式莫过于(rm -rf *)缓存目录。不过生产环境是绝对不能这么做的

2，模块实现

	nginx_ngx_cache_purge    模块可以清除缓存

	此模块是第三方模块，此模块nginx不是默认安装的，需要后续平滑安装

	下载地址：
		nginx第三方下载地址总览：
			https://www.nginx.com/resources/wiki/modules/
		nginx_ngx_cache_purge模块下载地址：
		 	http://labs.frickle.com/nginx_ngx_cache_purge/
			https://github.com/FRiCKLE/ngx_cache_purge/
			

	下载完模块安装包之后，如果nginx运行中，可进行平滑安装新模块。至于平滑安装，可参考我的另一篇笔记：
		知乎：https://zhuanlan.zhihu.com/p/152606216
		csdn:https://blog.csdn.net/SiuKong_Ngau/article/details/107071700
	

