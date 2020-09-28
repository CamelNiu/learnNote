##Mysql事务

	1，四大特性
	2，事务执行流程，redolog，undolog存放地址->日志现行
	3，undo.log实现原理,记录日志内操作相反的日志
	4，redo.log,mysql重启加载redo.log
	5,日志周期 
		创建日志，日志刷盘，数据刷盘，写入ckp
	6，日志大于数据
	7，超时的时候，undolog 
	8，innodb_flush_log_at_trx_commit,日志刷盘频率
	 	value:0,1,2
		0，写入缓冲区，每秒日志刷盘
		1,default,性能最差,数据最安全。
		2，折衷方案
	9, 

	show variables like 'innodb_log%';
	show engine innodb status;
	show variables like "innodb_flush_log_at_trx_commit"
 
	set @@innodb_flush_log_at_trx_commit = 0;
