###MySQL学习笔记

###1
1，视图(view)
		
		create [type] view_name

		create view shop as --select; 

		视图，相当于复杂查询的别名

		select * from view-name

		简化sql语句，相当于是一个逻辑表，虚拟表，不是物理表

		视图不能提高性能，相当于简化了sql语句

		视图提高了安全性，不暴露数据库重要字段

		降低耦合度，查询视图，重构表之后修改视图即可，不用修改程序


		视图常见场景：
			1，OA,ERP系统用的多


		注意：
			视图除了提供查询之外，还可以提供增删改


		缺点：
			并不能提高性能，大数据降低性能


		增删改操作视图和操作表一样

		with check 语句

		不能update，insert的情况
			1，有聚合函数
			2，包含子查询
			3，join
			4，常量视图


		复杂sql，行列转换


2,触发器：

	类似于框架中的事件，监听某个动作，鉴定到则触发事件

	create trigger 触发器名称 触发器执行事件 on 表 for each row [函数或者动作]			

	before

	after

	执行的动作：insert,update,delete

	函数：begin end，update,insert  

	web后端实际开发中：事件触发最好在程序里解决而不是写在sql里 

3,存储过程

	理解为一段sql的集合，实现一些业务逻辑。
	是事先编译好，且存储在数据库中

	create procedure name(arvg)
	begin
		代码区
	end;

	call procedure 调用
	
	注意：可以返回多个结果集

	参数IN/OUT
	
	IN
	OUT
	INOUT

	数据类型 int/varchar/char/flout/decimal/date/datetime/等等

	declare 定义变量


	php调用存储过程

		  就是写sql语句利用mysql或者mysqli扩展执行sql语句而已

	存储过程的循环，流程控制 
	if
	when then

	if then



	游标，常配合存储过程来使用，相当于迭代器

	declare name cursor for sql

	open name 打开游标

	fetch name into var

	close name

	游标一个资源，需要关闭

	游标都要做异常处理

	常见问题：
		存储过程好处：
			事先编译好的，提高性能
			减少网络io
			提高安全性 ，可以做权限控制、
			降低耦合度，修改存储过程即可，不用改动程序
		坏处：
			移植性差，因为跟数据库绑定
			修改不方便，不能更好调试，bug发现的更晚
			优势不明显，冗余。小型web来说根本用不上


	常见应用：


物化视图：

	mysql中并不存在，oracle和sqlserver中存在

	物化视图就相当于物理表，可以优化大数据量的问题

	数据量超大的时候 select (*) 会非常慢

	辅助索引
	物化视图：触发器，存储过程，变量


	意义：创建一个物理表，记录聚合操作的结果，最后把需要的数据从物化视图中拿取。利用触发器来保持实时的一致性，所以需要定时对存储过程进行更新

	select (*) 和 select(列名)的区别，*会统计null，列名的话不会统计null

	
		

	统计：oa，erp常用存储过程，视图等功能，做一些精确计算，财务报表啥的。其他项目禁止使用存储过程，存储函数，视图。



###2

	物化视图与事务

		视图：查询语句的别名，取得查询语句的结果集


	mysql实现物化视图：
		
		创建实际物理表，利用存储过程，触发器，游标来实现物化视图实时更新或者定时更新 
		  

	聚合查询：
		1，辅助索引
		2，物化视图 

	物化视图应用：
		聚合查询

	问题：
		物化视图和锁表的问题
		 


	物化视图，存储过程和触发器的综合运用


事务

	