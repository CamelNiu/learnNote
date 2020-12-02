### go语言学习笔记

1,资源整理

	go安装包下载地址
	https://golang.google.cn/dl/
	
	go语言中文手册地址：
	https://studygolang.com/pkgdoc
	
	
2,安装以及配置(mac下)

	1，下载安装包，然后点击即可自动安装
		安装目录：/usr/local/go/
	2，配置gopath(go项目路径，执行go项目可自动加载到而不用手动指定)
		export GOPATH=$HOME/go >> /etc/profile
	3，配置goroot
		export GOPATH=$HOME/go >> /etc/profile
		
	source /etc/profile
		
	查看配置：
		go env
		
3,基础命令
	go build 
		生成可执行文件，然后./file 可执行
	go run
		直接编译输出结果