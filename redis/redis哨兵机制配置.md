## Redis哨兵机制配置

**1.哨兵机制**

1.什么是redis哨兵？

		在redis主从复制架构中，假如master-redis宕机，整个redis系统就会瘫痪。
		要解决这个问题，只有人工在slave-redis执行slaveof no one选为新的master-redis。
		然后配置其他slave-redis复制新的master-redis。最后告知客户端，新的主节点地址，从节点地址。

		redis哨兵，就是把上面的操作自动化完成，不需要人工执行。目的就是保证redis主从复制系统的高可用。

2.哨兵集群是怎样的？

		在一个redis主从复制架构中，部署多台sentinel。
		每台sentinel会监控redis主从架构中的所有数据节点以及其他所有sentinel节点。当某个sentinel发现主节点不可用时，
		其他sentinel会对主节点进行监控。当确认主节点不可用的sentinel数量大于或等于配置数量的时候，表示redis主节点确实不可用。
		接下来所有sentinel会投票选举其中一台sentinel来进行故障转移。同时更新redis配置文件，通知redis客户端。

3.哨兵集群工作流程?

		1,master-redis宕机,从节点连接不到主节点，并且一直尝试连接
		2,所有sentinel对redis节点进行监控,某台sentinel发现redis-master宕机后，其他sentinel会来再次确认，确认数大于配置要求数量,则表示master-redis客观下线。
		3,sentinel之间会选举出一个sentinel。来执行故障转移。
		4,故障转移后,redis出从架构选出了新的主节点，其他从节点复制新的主节点。

		这个过程sentinel直接自动化完成，不需要人工干预。

4.官方给出的哨兵功能？

		1.监控 sentinel监控所有其他sentinel节点以及所有redis数据节点。
		2.通知 sentinel会把故障转移的结果通知给客户端(sentinel模式下客户端通过命令获取主从地址)
		3.主节点故障转移，从节点升级为主节点。其他从节点复制新的主节点。
		4.配置提供者，客户端可以直接从sentinel模式下获取主从的所有信息，相当于redis主从地址的配置文件

5.哨兵集群怎么启动？

		redis安装后在bin目录下,会有redis-sentinel的软连接到redis-server的可执行文件。redis-sentinel直接按照sentinel配置文件
		启动即可。启动方式有两种
			1.redis-server sentinel.conf --sentinel
			2.redis-sentinel sentinel.conf
		另外sentinel部署的时候最好部署奇数台，因为涉及投票。

		注意:sentinel.conf 就是默认的redis.conf再加几行配置。详情下面有罗列

**2.配置**

1.配置文件sentinel.conf核心配置项

		复制初始的redis.conf，改名为sentinel.conf。比redis.conf再多加几行sentinel特有的配置即可。下面是sentinel特有配置描述

		sentinel monitor master1 x.x.x.x 6379 2
			 --表示sentinel要监控的主节点信息。master1是主节点别名，因为有可能一台sentinel监控多个主节点。x.x.x.x表示主节点host，6379表示主节点port,2表示有2台哨兵确认主节点下线则主节点客观下线。注意2这个地方不能大于哨兵总数，要不然永远都不会故障转移
		sentinel down-after-milliseconds master1 30000
			 --表示数据节点ping不通超时时间。单位微秒，默认30000，即30s。也就是说哨兵监控某个数据节点30s未收到回复表示当前sentinel认定为主观下线。
		sentinel parallel-syncs master1 1
			 --故障转移之后，从节点向新的主节点发起复制操作的从节点个数。默认为1表示一次只能一台进行复制。如果设置为大于1的话，多台从节点一起复制会增加主节点的压力。建议没有特殊必要设置为1
		sentinel failover-timeout master1 180000
			 --故障转移超时时间,超过180000也就是3min没有完成则表示故障转移失败
		sentinel auth-pass xxxxxx...
			 --表示监控主节点的密码，主节点没设密码无需配置

		上面说了这么多，也就是给sentinel.conf加一下配置即可。另外要修改bind 0.0.0.0 以及后台模式运行。

2.核心配置列表

		//sentinel就是不存数据的redis节点，所以也要按照redis的配置为可远程连接，后台运行
		#bind 0.0.0.0
		protected-mode no
		daemonize no
		port 26379 //最好不要跟redis节点的端口重复
		//sentinel核心配置
		sentinel monitor mymaster 8.8.8.5 6379 2
		sentinel parallel-syncs master1 1
		sentinel down-after-milliseconds mymaster 1000
		sentinel failover-timeout master1 180000
		#sentinel auth-pass xxxxxx...
3.启动

		redis-server sentinel.conf --sentinel
		redis-sentinel sentinel.conf

		注意：真实情况下，可执行文件以及配置文件的路径要正确

		启动之后sentinel就开始监控redis主从节点以及其他sentinel。也就是说哨兵部署完成

4.主从监控

		sentinel配置了主节点监控信息且启动的时候，会自从根据主节点获取到从节点信息以及同时监控当前主节点的其他sentinel信息。然后对所有的节点进行监控。
		不需要另外配置监控从节点以及其他sentinel

5.配置文件

		sentinel启动的时候，会自动更新sentinel.conf,故障转移后sentinel会自动更新redis.conf的replicaof项

		1，再sentinel.conf追加一下配置

			sentinel config-epoch mymaster 9
			sentinel leader-epoch mymaster 10
			sentinel known-replica mymaster 8.8.8.2 6379
			sentinel known-replica mymaster 8.8.8.3 6379
			sentinel known-replica mymaster 8.8.8.4 6379
			sentinel known-sentinel mymaster 8.8.8.11 26379 4c65f3fd882466efc8c363fa8f111ddfefeca624
			sentinel known-sentinel mymaster 8.8.8.12 26379 5c9ff5f776653263e9ee1fefeb3e957dda21fdae
			sentinel current-epoch 10

		2，在从节点redis.conf修改replicaof项，更新为新的主节点host,port

**3，常用命令**

		sentinel masters  							--获取所有监控的主节点信息
		sentinel master masterName				    --获取监控的当前名称的主节点信息
		sentinel slaves masterName 					--获取监控的当前名称的主节点下的从节点信息
		sentinel failover masterName				--强制当前名称的主节点进行故障转移
		sentinel get-master-addr-by-name masterName --获取当前名称的主节点的ip以及port