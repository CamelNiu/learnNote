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