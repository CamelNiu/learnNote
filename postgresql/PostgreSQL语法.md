### PostgreSql语法

#### 1,语法查询

	\h
	\h option
	
#### 2,数据类型

	smallint
	integer
	bigint
	decimal
	numeric
	real
	double precision
	smallserial
	serial
	bigserial
	
	money
	
	
	text
	character
	char
	character varying varchar
	
	timestamp without time zone 
	timestamp with time zone
	
	date
	
	time without tine zone
	time with time zone
	
	interval
	
	boolean
	
	create type mood as enum('a','b')
	
	point
	line
	lseg
	box
	path
	path
	polygon
	circle
	
	cidr
	inet
	macaddr
	
	bit
	bit varying
	
	tsvector
	tsquery
	
	uuid
	
	xml 
	configure --with-libxml
	
	json
	array_to_json
	row_to_json
	
	integer []
	text[]
	
	integer array[5]
	
	{}{}
	
	{}插入数组，array[1,2,3]插入数组，保存后展现为{1,2,3}
	
	select * from a where b[1] = 1 or b[2]=2 or b[3]=3 or b[4]=4;
	
	
	select * from
		(select * from as ) as foo
	where a = ;
	
	符合类型
	
	create type a as (1,2);
	create type 
	
	复合类型'()'
	"('fuzzy',45)"
	
	select (a).b from c where (c).f=a;
	
	
	int4range
	int8range
	numrange
	
	伪类型
	
	创建数据库
	
		create database
		createdb
		pgadmin
		
		create database a;
		create database runoobdb;
		
		createdb
		
		
		\l
		
		\c dbname
		
		drop database
		dropdb
		
		create table 
		
		\d表
		
		\d tablename
	
		drop table tablename
		
		schema 模式。一个表的集合
		一个模式可以包含视图、索引、数据类型、函数和操作符等。
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	