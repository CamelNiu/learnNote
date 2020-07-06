## Nginx 负载均衡(动态实现)

##### 1，概览
	
	1，传统配置实现的负载均衡,在加减服务器的时候，会遇到下面的问题	
		1：配置文件是默认地址，则需要重载配置文件。nginx -s reload
			加载配置文件流程：
				1,主进程通知worker进程进行重启
				2,worker进程收到通知，等待现有请求处理完毕，然后进行重启
				3,重启过程中的请求无法处理，会堆积一些无法处理的请求
				4,重启完毕，先处理堆积的请求，然后处理后续的请求
		2：配置文件不是默认地址,需要关闭nginx,指定配置文件重启，用以加载新的配置文件。
	
		#注意：以上两种方法，测试环境当然不会有问题。如果是生成环境，正值请求高峰的话，这么做是绝对不允许的。

	这样，就产生了实现动态负载均衡的方法。
		
	动态负载均衡实现原理：
		1.配置方面，和静态配置一摸一样，用upstream模块。将多个后端服务器的配置独立出来，include引入。
		2.利用consul服务维护多个后端服务器的地址以及配置信息，可扩展，缩减，修改后端服务器
		2.利用nginx-upsync-module模块，动态读取consul维护的后端服务器信息，写入1中独立出来
		  的后端服务器配置中，并且加载到运行中的nginx中，整个过程不需要重新加载nginx。



##### 2，consul

1，简介

	consul其实就是个服务发现、配置管理中心的服务软件。
		（具体安装配置等细节可自行google，介绍使用都很详细。这里只介绍几个和nginx负载均衡相关的命令）

2，启动命令：


	consul agent -server  -bootstrap-expect 1 -data-dir /tmp/consul -node=abc -  bind=8.8.8.2 -ui -client=0.0.0.0 

		详解：
	 		consul agent
		    -server  				#表示启动的是一个服务 
			-bootstrap-expect n  	#表示有n个节点之后再启动，没特殊分布式部署，n=1即可
			-data-dir /tmp/consul   #数据存储目录	
			-node=ali  			    #当前服务节点的别名
			-bind=0.0.0.0           #当前作为consul服务器的ip
			-ui 			        #启动默认ui界面
			-client=0.0.0.0 		#绑定client的地址，0.0.0.0表示所有客户端都可以访问
	
		注意：
			1，http服务默认是8500端口，开启ui界面的话，host:8500可进行可视化管理

    实例：
	consul agent -server  -bootstrap-expect 1 -data-dir /tmp/consul -node=abc -bind=8.8.8.2 -ui -client=0.0.0.0 

4，常用命令:

		1，增加新配置
			curl -X PUT -d '{"weight":1, "max_fails":2, "fail_timeout":10}' http://$consul_ip:$consul_port/v1/kv/$dir1/$upstream_name/$server_ip:$server_port

			例如：
				curl -X PUT -d '{"weight":2, "max_fails":2, "fail_timeout":10}' http://8.8.8.2:8500/v1/kv/upstreams/syncTest/8.8.8.3:9001


		2,查看所有的配置
			curl http://127.0.0.1:8500/v1/kv/?recurse


		3,删除某个key
			consul kv delete key(key 可以在上面查询所有配置中拿到)


##### 3，nginx配置

	http{

		……

	    upstream syncTest{
			#先给定一个服务器
			server  8.8.8.3:9001;

			#upsync,									这里的配置用了nginx-upsync-module模块
			#127.0.0.1:8500/v1/kv/upstreams/syncTest    consule服务器地址
			#upsync_timeout=6m  						超时时间6min
			#upsync_interval=500ms 						配置从consul拉取上游服务器的间隔时间
			#upsync_type  								指定使用配置服务器的类型，当前是consul
			#strong_dependency 	 						启动时是否强制依赖配置服务器，如果配置为on,则拉取失败，nginx同样会启用失败
	        upsync  127.0.0.1:8500/v1/kv/upstreams/syncTest upsync_timeout=6m upsync_interval=500ms  upsync_type=consul  strong_dependency=off strong_dependency=off;

			#指定从consul拉取的上游服务器后持久化到的位
	        upsync_dump_path /data/www/learnNote/nginx/servers_test.conf;
			#引入备份文件
	        include /data/www/learnNote/nginx/servers_test.conf;
		}
		……

		server{
			
			……

			location / {
				#负载均衡转发
            	proxy_pass http://syncTest;
        	}

			……

		}

    }


	#归纳：
		当consul扩展或者缩减服务器的时候,相应服务器配置文件会自动更新
		归根结底，和静态配置唯一的不同就是用upsync模块定时自动拉去consul维护的服务器信息。
		再简单点，就是upstream配置中，再加两条upsync,upsync_dump_path两条配置

#注意：

	本文主要讲了动态负载均衡的原理，实现。
	需要了解静态负载均衡配置的知识，才能了解本文的动态的配置，静态配置可以查看上一篇总结
	地址：
		知乎：https://zhuanlan.zhihu.com/p/157213928
		csdn:https://blog.csdn.net/SiuKong_Ngau/article/details/107069817