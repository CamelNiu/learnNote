###Redis主从

**1.概览**

	redis主从复制简单来说就是从库复制主库数据的副本，存在多个redis节点上。
	目的主要是数据备份，以及实现读写分离提高性能

**2.实现**

	1.命令行    slaveof host port                   (重启失效)       临时
	2.启动      redis-server --salveof host port    (重启生效)       临时
	3.配置文件  slaveof host port                    (永久生效)      永久

	注意：平时练习命令行可配置主从进行学习，一般生产环境都是配置文件实现主从。本文主要记录配置文件实现主从的一些学习

**3.配置文件：**

`1`.redis支持远程连接

	protected-mode no/yes   //是否是受保护模式，如果开启的话无法远程连接
	bind 127.0.0.1          //设定只能连接的ip，注释掉即可
	
	完成上面两项配置,重启reids即可远程连接

`2`.redis主从

    replicaof X.X.X.X 6379     
	slaveof   x.x.x.x 6379
	以上两个配置都能实现主从，第一个比较常用

	masterauth xxxxxx   如果主节点设了密码则用这条语句配置密码

	注意：如果不同机器的redis配置主从，必须要让redis支持远程连接

**4.查看**

	info replication 

	例如：
		1.主机主从详情
			127.0.0.1:6379> info replication
			# Replication
			role:master//slave/master,本机身份说明
			connected_slaves:3 //从机数量
			slave0:ip=8.8.8.2,port=6379,state=online,offset=40503933,lag=0 //从节点详情
			slave1:ip=8.8.8.4,port=6379,state=online,offset=40503933,lag=1
			slave2:ip=8.8.8.3,port=6379,state=online,offset=40503933,lag=0
			master_replid:452af1ff0970dde5cb7661c0554e0bf1a1f757c7
			master_replid2:8a554b38126e906dcd5526926f5a9aead7c2aaeb
			master_repl_offset:40503933//主节点复制偏移量
			second_repl_offset:40123444
			repl_backlog_active:1
			repl_backlog_size:1048576
			repl_backlog_first_byte_offset:40122878
			repl_backlog_histlen:381056
			127.0.0.1:6379> 

		2.从机主从详情
			127.0.0.1:6379> info replication
			# Replication
			role:slave   //slave/master,本机身份说明
			master_host:8.8.8.5  //主节点host
			master_port:6379
			master_link_status:up
			master_last_io_seconds_ago:2
			master_sync_in_progress:0
			slave_repl_offset:40481116//从节点复制偏移量
			slave_priority:100
			slave_read_only:1
			connected_slaves:0
			master_replid:452af1ff0970dde5cb7661c0554e0bf1a1f757c7
			master_replid2:8a554b38126e906dcd5526926f5a9aead7c2aaeb
			master_repl_offset:40481116//主节点复制偏移量
			second_repl_offset:40123444
			repl_backlog_active:1
			repl_backlog_size:1048576
			repl_backlog_first_byte_offset:40123031
			repl_backlog_histlen:358086
			127.0.0.1:6379> 

		注意：
			以上就是redis主从复制的详情信息，每条信息具体代表的参数的意义直接百度即可。主要的几条都做了解释

**5扩展**

		1，slave no one 可以让从机断开主机主从复制，从机升级为主节点

		2，Reids主从复制相当灵活，可以进行一主一从，一主多从，树状结构。但是不能一丛多主

**其他**

		关于主从问题的一些优化配置：

		slave-serve-stale-data  //slave和master连接中断时的配置,yes表示中断后继续接受客户端请求。no表示中断后除了系统命令不接受客户端请求(主要防止客户端拿到脏数据)
		slave-read-only         //从库是否可写，为了主从数据一致性，建议为no
		repl-disable-tcp-nodelay //是否禁用socker的NO_DELAY。yes表示禁用，tcp协议会合并小包统一发送数据。减少主节点包数量且节省宽带。但是延迟较大。no表示启用，tcp会根据redis自己的数据同步进行发送，消耗宽带,降低延迟。
		slave-priority          //从库优先级，哨兵会根据优先级选择master.如果配置为0，则永远不会被提升为master