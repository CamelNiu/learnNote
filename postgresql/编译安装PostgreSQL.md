## 编译安装PostgreSQL

#### 1,简介：
	1,服务器环境：
	
		利用docker下最小化安装的centos7镜像，编译安装PostgreSQL，且添加扩展
		
	2,PostgreSQL版本：
	
		postgresql-10.1.tar.gz
		
		下载地址：
			wget https://ftp.postgresql.org/pub/source/v10.1/postgresql-10.1.tar.gz
		附：
			https://ftp.postgresql.org/pub/source/ (所有PostgreSQL源码包下载地址)
			
	3, PostgreSQL扩展版本
	
		pg_pathman.1.4.8.tar.gz
			下载地址：https://github.com/postgrespro/pg_pathman/archive/1.4.8.tar.gz
		pglogical-2.1.0.tar.gz
			下载地址：https://github.com/2ndQuadrant/pglogical/archive/REL2_0_1.tar.gz
			
#### 2,准备环境

	1，拉取镜像
		
		docker pull centos:7
		
	2，实例化容器
	
		docker run -itd --name pgsql -v /data/www:/data/www --network=mynet --ip 8.8.8.17 -p 15433:5433 centos:7
		
	3，查看容器
	
		docker ps
		
	4,进入容器
	
		docker exec -it pgsql /bin/bash

#### 3,编译安装
	1，安装依赖
		yum -y install openssl-devel libxml2-devel libxslt-devel python-devel cmake gcc-c++ zlib-devel bzip2 readline-devel expect git uuid-devel systemd-devel gcc automake autoconf libtool make vim wget

	2，创建用户
		useradd postgres
		
	3，创建安装过程所需目录，且授权
		mkdir -p /usr/local/postgresql
		mkdir -p /usr/local/postgresql
		chown -R postgres.postgres /usr/local/postgresql
		
	4，解压目录，进入目录
		tar -zxvf postgresql-10.1.tar.gz
		cd postgresql-10.1
		
	5，安装
		1,检查参数
			./configure \
			--prefix=/usr/local/postgresql \
			--with-pgport=5432 \
			--with-openssl \
			--disable-float4-byval \
			--disable-float8-byval \
			--with-libxml \
			--with-libxslt \
			--with-ossp-uuid \
			--with-systemd
		2，编译
			gmake world
		3，安装
			gmake install-world
			
		注意：
			编译时使用了gmake world和gmake install-world, 表示安装所有插件
		
		如果没有报错，则表示安装成功

#### 4,初始化数据,开启服务

		1，配置环境变量
			vim /etc/profile.d/pgdb.sh
			
			export PGDATA=/usr/local/postgresql/data
			export PATH=/usr/local/postgresql/bin:$PATH
			
			source /etc/profile.d/pgdb.sh
			
		2,初始化数据
			1,切换用户
				su - postgres		
		
			2,初始化数据
			/usr/local/postgresql/bin/initdb -D /usr/local/postgresql/data --encoding=UTF8 --lc-collate=en_US.UTF-8 --lc-ctype=en_US.UTF-8
			

		3，服务管理
			/usr/local/postgresql/bin/pg_ctl -D /usr/local/postgresql/data -l logfile {start|stop|restart}



#### 5,安装第三方扩展

	1,编译安装
		1,pathman
			tar -zxvf 1.4.8.tar.gz && cd pg_pathman-1.4.8/
			make USE_PGXS=1
			make USE_PGXS=1 install
			
		2, pglogical
			tar -zxvf REL2_1_0.tar.gz && cd pglogical-REL2_1_0/
			make USE_PGXS=1
			make USE_PGXS=1 install
			
	2，更新配置文件
		
		文件地址：	
		/usr/local/postgresql/data/postgresql.conf
		配置：
		大约145行
		shared_preload_libraries = 'pglogical,pg_pathman'
		
	3,应用扩展
		1,切换用户
			su - postgres
		2,重启服务
			/usr/local/postgresql/bin/pg_ctl -D /usr/local/postgresql/data -l logfile restart
		3,进入pgsql命令行
			/usr/local/postgresql/bin/psql
			
			create extension pglogical;
			create extension pg_pathman;
			\dx		查看已安装扩展
			
			
			例如：
				[postgres@cf30b9d156c3 ~]$ /usr/local/postgresql/bin/psql
				psql (10.1)
				Type "help" for help.
				
				postgres=# create extension pglogical;
				CREATE EXTENSION
				postgres=# create extension pg_pathman;
				CREATE EXTENSION
				postgres=# \dx
				                     List of installed extensions
				    Name    | Version |   Schema   |           Description
				------------+---------+------------+----------------------------------
				 pg_pathman | 1.4     | public     | Partitioning tool for PostgreSQL
				 pglogical  | 2.1.0   | pglogical  | PostgreSQL Logical Replication
				 plpgsql    | 1.0     | pg_catalog | PL/pgSQL procedural language
				(3 rows)
				
				postgres=#
					
			
					



	




















	