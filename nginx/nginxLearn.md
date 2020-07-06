###nginx

	nginx网络模型

	单核cpu运行进程原理
	进程争抢cpu执行权

	死循环：密集型io，cpu无法释放
	time php index.php
	sleep() 进程得不到cpu执行权

	用户空间先内核空间发送指令

	单核cpu同步阻塞


nginx优化
	增大worker

	绑定cpu


nginx限流和限ip，重定向

	nginx和apache

	1，
		nginx,master-多进程io多路复用模型
		apache是多进程同步阻塞模型

		抗压能力差

	2,nginx轻量级

	3apache稳定

	4nginx负载均衡，反向代理

	5apache适用动态代理


	nginx常用模块


负载均衡


	自定义hash 
		规则
	
	vip用户进不同性能的服务器 

		hash $key;
		$geo来确定服务器，了解内部算法


	失败重试

		进程影响演示
		cpu加载，缓存
		两次错误两个进程 

		ntlp

	平滑重启，新模块安装
		


	动态负载均衡

		
	consul做动态负载均衡
		


nginx缓存

	expires 静态资源缓存

	动态缓存：
		proxy模块

		proxy_cache_path

	key_zone
	max_size
	inactive
	expired


nginxio

	 syn攻击

		tcp/udp通信协议
		
		tcp
		
		nginx
			监听socket
			seq,ack

		syn队列


	crsf

	
nagle

gzip

	就是压缩服务器的回传数据     

磁盘IO优化

	零拷贝-零复制
		  
		
		大文件，磁盘io的缓冲

	sendfile零拷贝提升性能