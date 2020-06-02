## docker容器指定ip

1，docker下的网络模式概览 

	docker安装后，会默认三种网络类型。(bridge,none,host)

	查看dockers的网络类型
	docker network list

	bridge	桥接网络       默认网络类型，容器内不特殊指定，就用此类型。不特殊指定的话,分配的ip为172.17.0.x
	none    无指定网络     容器内不指定局域网ip
	host    主机网络       和主机共用一个ip，会出现和宿主机争抢端口情况,非特殊需要尽量少用
	
2，docker容器自定义ip理解

	根据docker网络模式，
		bridge 可以自定义网桥进行固定ip	
		none   无指定网络肯定不行
		host   使用主机网络会跟宿主机挣钱端口，所以并不常用

	最常用的就是利用bridge,自定义虚拟网桥来固定ip


	默认情况下,docker的容器重启之后，会自动分配ip，导致一次重启ip变化。所以需要对docker容器指定ip

	由于docker默认的网络不能固定ip地址,我们创建自定义虚拟网桥,进行固定ip的分配

3，docker自定义ip操作

 	docker network create --subnet=x.x.x.0/24 netBridgeName(网桥名称，随便写即可)		    ----创建网桥
	docker run -itd --network=netBridgeName --ip x.x.x.8 --name dockerName imageName    ----指定ip
	docker network list 																----查看docker下网络模式
	docker network rm netBridgeName													    ----删除创建的网桥


	值得注意的是：网络段不要和主机网络段冲突，要不然会影响宿主机