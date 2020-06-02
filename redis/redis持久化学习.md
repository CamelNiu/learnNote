# redis数据备份(持久化)

###1,简介：
	
	redis持久化主要有以下两种方式来进行
		RDB: 数据按照配置定期快照方式保存，默认文件名为dump.rdb       redis重启自动加载
		AOF: 操作命令追加日志的方式来保存，默认文件名appendonly.aof   redis重启自动加载

		config get dir  查找redis安装目录,也就是dump.rdb的目录。
		redis重启时，dump.rdb文件放在redis安装目录,则redis会自动加载数据(默认为安装目录,地址可配置)

###2,RDB详解：

######1,rdb备份详情：

	RDB快照触发机制 
		1，手动触发
			
			save            单进程执行,执行完成前阻塞操作     (不常用)
			bgsave          fork一个子进程执行,不影响主进程   (常用,且redis内部操作都是bgsave)


		2，自动触发

			1，常见自动触发场景

				1，主从复制中从节点进行全量复制,主节点自动执行bgsave,然后将rdb文件发给从节点
				2，debug reload 命令的时候。(debug reload命令的意思是快照rdb文件，清空数据库,然后重新加载rdb)
				3,shutdown 命令 

			2，配置文件自动触发

				################################ SNAPSHOTTING  ################################
				#
				# Save the DB on disk:
				#
				#   save <seconds> <changes>
				#
				#   Will save the DB if both the given number of seconds and the given
				#   number of write operations against the DB occurred.
				#
				#   In the example below the behaviour will be to save:
				#   after 900 sec (15 min) if at least 1 key changed
				#   after 300 sec (5 min) if at least 10 keys changed
				#   after 60 sec if at least 10000 keys changed
				#
				#   Note: you can disable saving completely by commenting out all "save" lines.
				#
				#   It is also possible to remove all the previously configured save
				#   points by adding a save directive with a single empty string argument
				#   like in the following example:
				#
				#   save ""
				
				save 900 1           //900s内至少一个写命令则bgsave
				save 300 10          //300s内至少10个写命令则bgsave
				save 60 10000	     //60s内至少10000条写命令
				#以上是save触发配置的默认值,可根据需要修改
				
				# By default Redis will stop accepting writes if RDB snapshots are enabled
				# (at least one save point) and the latest background save failed.
				# This will make the user aware (in a hard way) that data is not persisting
				# on disk properly, otherwise chances are that no one will notice and some
				# disaster will happen.
				#
				# If the background saving process will start working again Redis will
				# automatically allow writes again.
				#
				# However if you have setup your proper monitoring of the Redis server
				# and persistence, you may want to disable this feature so that Redis will
				# continue to work as usual even if there are problems with disk,
				# permissions, and so forth.
				stop-writes-on-bgsave-error yes //假如bgsave出错后,redis主进程是否支持继续写入（yes不可写入,no继续写入）
				# Compress string objects using LZF when dump .rdb databases?
				# For default that's set to 'yes' as it's almost always a win.
				# If you want to save some CPU in the saving child set it to 'no' but
				# the dataset will likely be bigger if you have compressible values or keys.
				rdbcompression yes   //rdb文件是否压缩,yes压缩,但是会影响cpu时间,no不压缩,这样快一点但是rdb文件会过大
				
				# Since version 5 of RDB a CRC64 checksum is placed at the end of the file.
				# This makes the format more resistant to corruption but there is a performance
				# hit to pay (around 10%) when saving and loading RDB files, so you can disable it
				# for maximum performances.
				#
				# RDB files created with checksum disabled have a checksum of zero that will
				# tell the loading code to skip the check.
				rdbchecksum yes      //对rdb文件是否进行校验,默认开启,开启会影响cpu资源
				
				# The filename where to dump the DB
				dbfilename dump.rdb    //rdb文件名,可自行配置，默认dump.rdb
				
				# The working directory.
				#
				# The DB will be written inside this directory, with the filename specified
				# above using the 'dbfilename' configuration directive.
				#
				# The Append Only File will also be created inside this directory.
				#
				# Note that you must specify a directory here, not a file name.
				dir ./               //rdb文件的目录，可自信配置
				
				################################# REPLICATION #################################
				


				上面一段配置文件是获取的redis,rdb持久化的纯净配置文件。
				比较常用的就是
				save m n 
				dir rdb_path

######2,常见命令：

				info stats 下 latest_fork_usec，可以获取最近一个bgsave所用的时间
				执行latesave 可以获取最后一个生成rdb的时间,返回一个时间戳

				还有很多其他详情，对开发来说并不常用,需要查询的时候度娘即可

######3,总结：

				rdb备份的优点主要就是rdb文件小，恢复数据比较快。备份是子进程执行的,不会影响主进程。缺点就是如果写入频繁的话，无法做到实时备份。


###2,AOF详解：

######1,aof备份详情：

	简介：
		aof区别于rdb,aof是通过操作日志追加来持久化reids操作。
		就是客户端每一次对操作命令写入日志当中,追加aof文件。

	触发机制：
		1，手动触发：
			bgrewriteaof 

		2,自动触发：
			redis默认关闭aof备份，需要在配置文件中开启。

		aof备份redis数据配置文件
		############################## APPEND ONLY MODE ###############################

		# By default Redis asynchronously dumps the dataset on disk. This mode is
		# good enough in many applications, but an issue with the Redis process or
		# a power outage may result into a few minutes of writes lost (depending on
		# the configured save points).
		#
		# The Append Only File is an alternative persistence mode that provides
		# much better durability. For instance using the default data fsync policy
		# (see later in the config file) Redis can lose just one second of writes in a
		# dramatic event like a server power outage, or a single write if something
		# wrong with the Redis process itself happens, but the operating system is
		# still running correctly.
		#
		# AOF and RDB persistence can be enabled at the same time without problems.
		# If the AOF is enabled on startup Redis will load the AOF, that is the file
		# with the better durability guarantees.
		#
		# Please check http://redis.io/topics/persistence for more information.
		
		appendonly no	//是否开启aof持久化
		
		# The name of the append only file (default: "appendonly.aof")
		
		appendfilename "appendonly.aof"  //aof持久化文件
		
		# The fsync() call tells the Operating System to actually write data on disk
		# instead of waiting for more data in the output buffer. Some OS will really flush
		# data on disk, some other OS will just try to do it ASAP.
		#
		# Redis supports three different modes:
		#
		# no: don't fsync, just let the OS flush the data when it wants. Faster.
		# always: fsync after every write to the append only log. Slow, Safest.
		# everysec: fsync only one time every second. Compromise.
		#
		# The default is "everysec", as that's usually the right compromise between
		# speed and data safety. It's up to you to understand if you can relax this to
		# "no" that will let the operating system flush the output buffer when
		# it wants, for better performances (but if you can live with the idea of
		# some data loss consider the default persistence mode that's snapshotting),
		# or on the contrary, use "always" that's very slow but a bit safer than
		# everysec.
		#
		# More details please check the following article:
		# http://antirez.com/post/redis-persistence-demystified.html
		#
		# If unsure, use "everysec".
		
		# appendfsync always  //每一个操作后立即写入磁盘。
		appendfsync everysec  //每秒钟统计操作,写入磁盘。
		# appendfsync no      //依赖操作系统将数据写入磁盘。大部分linux默认30s
		
		# When the AOF fsync policy is set to always or everysec, and a background
		# saving process (a background save or AOF log background rewriting) is
		# performing a lot of I/O against the disk, in some Linux configurations
		# Redis may block too long on the fsync() call. Note that there is no fix for
		# this currently, as even performing fsync in a different thread will block
		# our synchronous write(2) call.
		#
		# In order to mitigate this problem it's possible to use the following option
		# that will prevent fsync() from being called in the main process while a
		# BGSAVE or BGREWRITEAOF is in progress.
		#
		# This means that while another child is saving, the durability of Redis is
		# the same as "appendfsync none". In practical terms, this means that it is
		# possible to lose up to 30 seconds of log in the worst scenario (with the
		# default Linux settings).
		#
		# If you have latency problems turn this to "yes". Otherwise leave it as
		# "no" that is the safest pick from the point of view of durability.
		
		no-appendfsync-on-rewrite no //子进程重写的时候,主进程是否操作磁盘。设置为yes,则同意主进程也操作磁盘，子进程没结束,主进程阻塞。设置为no，子进程主进程互不相干。子进程操作磁盘,主进程不操作磁盘只写入缓冲区
		
		# Automatic rewrite of the append only file.
		# Redis is able to automatically rewrite the log file implicitly calling
		# BGREWRITEAOF when the AOF log size grows by the specified percentage.
		#
		# This is how it works: Redis remembers the size of the AOF file after the
		# latest rewrite (if no rewrite has happened since the restart, the size of
		# the AOF at startup is used).
		#
		# This base size is compared to the current size. If the current size is
		# bigger than the specified percentage, the rewrite is triggered. Also
		# you need to specify a minimal size for the AOF file to be rewritten, this
		# is useful to avoid rewriting the AOF file even if the percentage increase
		# is reached but it is still pretty small.
		#
		# Specify a percentage of zero in order to disable the automatic AOF
		# rewrite feature.
		
		auto-aof-rewrite-percentage 100 //当前aof文件超过了上一个操作的aof文件的100%，则进行重写
		auto-aof-rewrite-min-size 64mb  //当前aof文件大于64mb,则进行重写
		
		# An AOF file may be found to be truncated at the end during the Redis
		# startup process, when the AOF data gets loaded back into memory.
		# This may happen when the system where Redis is running
		# crashes, especially when an ext4 filesystem is mounted without the
		# data=ordered option (however this can't happen when Redis itself
		# crashes or aborts but the operating system still works correctly).
		#
		# Redis can either exit with an error when this happens, or load as much
		# data as possible (the default now) and start if the AOF file is found
		# to be truncated at the end. The following option controls this behavior.
		#
		# If aof-load-truncated is set to yes, a truncated AOF file is loaded and
		# the Redis server starts emitting a log to inform the user of the event.
		# Otherwise if the option is set to no, the server aborts with an error
		# and refuses to start. When the option is set to no, the user requires
		# to fix the AOF file using the "redis-check-aof" utility before to restart
		# the server.
		#
		# Note that if the AOF file will be found to be corrupted in the middle
		# the server will still exit with an error. This option only applies when
		# Redis will try to read more data from the AOF file but not enough bytes
		# will be found.
		aof-load-truncated yes //redis恢复数据的时候,是否忽略最后一条指令。yes忽略。no不忽略。设置为no的时候,如果最后一条指令有问题则redis恢复失败
		
		# When rewriting the AOF file, Redis is able to use an RDB preamble in the
		# AOF file for faster rewrites and recoveries. When this option is turned
		# on the rewritten AOF file is composed of two different stanzas:
		#
		#   [RDB file][AOF tail]
		#
		# When loading Redis recognizes that the AOF file starts with the "REDIS"
		# string and loads the prefixed RDB file, and continues loading the AOF
		# tail.
		aof-use-rdb-preamble yes  //是否开启aof/rdb混合持久化设置(redis恢复数据时候用到)。设置为yes的时候，重写之前的数据做rdb快照，并且将rdb快照内容和增量aof内存数据的命令存在一起，都写入新的aof文件。增加恢复数据时候的速度
		
		################################ LUA SCRIPTING  ###############################

		常用配置

			appendonly no	//是否开启aof持久化
			appendfilename "appendonly.aof"  //aof持久化文件
			appendfsync always  //每一个操作后立即写入磁盘。
			appendfsync everysec  //每秒钟统计操作,写入磁盘。
			appendfsync no      //依赖操作系统将数据写入磁盘。大部分linux默认30s
			auto-aof-rewrite-percentage 100 //当前aof文件超过了上一个操作的aof文件的100%，则进行重写
			auto-aof-rewrite-min-size 64mb  //当前aof文件大于64mb,则进行重写

######2,常见命令：

				bgrewriteaof 手动重写
				redis-check-aof fileName.aof   //aof文件有损坏的情况下,修改aof文件
				还有很多其他详细命令，对开发来说并不常用,需要的时候度娘即可

######3,总结：
	
			aof优点可以精确到每个指令都同步。aof且是日志型备份,所有操作相对独立。可恢复到任何一个节点。
			缺点就是aof文件相对rdb大很多,redis恢复数据的时候效率比较低

				
