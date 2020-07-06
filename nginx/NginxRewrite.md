### Nginx rewrite模块

**1.详细文档**

	淘宝团队翻译的详细文档

	http://tengine.taobao.org/nginx_docs/cn/docs/http/ngx_http_rewrite_module.html

**2.简介**

	ngx_http_rewrite_module模块允许正则替换URI，返回页面重定向，和按条件选择配置

	执行顺序：
		1，server级别的定义
		2，location定义的模块指令
		3，如果location中重新向别的location，则再执行新的location中的定义指令。
		   如果这个循环重复10次，nginx则报500错误

**2.配置指令**

	1.if
		if ( condition ){ ... }
		上下文：server,location
		注意:血的教训，if和括号之间一定要有一个空格，没有的话报错

		condition:
			#1.变量,如果为空或者0开头字符则为假
			#2.=和!= 做比较
			#3.使用“-f”和“!-f”运算符检查文件是否存在；
			#4.使用“-d”和“!-d”运算符检查目录是否存在；
			#5.使用“-e”和“!-e”运算符检查文件、目录或符号链接是否存在；
			#6.使用“-x”和“!-x”运算符检查可执行文件
			#7.~区分大小写 *~不区分大小写，匹配变量和正则表达式。如果含有敏感字符`{`,`}`,`;`则表达式需要引号
										匹配到的字符按照匹配到的顺序用$1-$9代替

	2，break
		上下文：server,location,if
		停止处理当前这一轮的ngx_http_rewrite_module指令集

	3，return
		上下文：server,location,if

		   return code text
		   return code url;
		   return url;

		location ~ .*\.(sh|bash)?${
			return 500；
		}

	4，rewrite / rewrite_log

		rewrite regex replacement [flag]
		上下文：server,location,if
		flag参数：last,break,redirect,permanent
			#last			匹配完成后，继续向下匹配新的location URL规则，超过10次则500.
						    也就是rewrite匹配成功后根据新的规则继续向下匹配，不能超过10次
			#break			rewrite匹配成功后终止，不继续向下匹配任何其他规则
			#redirect       返回302临时重定向，浏览器地址会显示跳转后的URL地址
			#permanent		返回301永久重定向，浏览器地址栏会显示跳转后的URL地址

		语法: 	rewrite_log on | off;
		默认值: 	rewrite_log off;
		上下文: 	http, server, location, if

    5,set

		语法: 	set variable value;
		默认值: 	—
		上下文: 	server, location, if


**3.实例**

	rewrite中，最常用的就是rewrite regex replacement [flag] if等。
	上面是简单理论知识，后续会维护本实例，让内容越来越丰富

	127.0.0.1/public/index.php?id=8&type=1 重写为127.0.0.1/public/index/id/8/type/1.html
	#这样就把127.0.0.1/public/index/id/8/type/1.html重写为标准的.php?param=value格式
	location ~ \.html {
		rewrite ^/public/index/id/(.*)/type/(.*).html$ /public/index.php?id=$1&type=$2 last
	}
