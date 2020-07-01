## Nginx 负载均衡

##### 1，概览

	负载均衡，就是单个服务无法承受访问压力的时候，通过一个入口把请求分发到不同的实际处理业务的服务上。

	后端业务中，可以用nginx实现上游服务器负载均衡，把请求分发给不同的服务器。也可以实现下游数据库负载
	均衡，比如多台mysql负载均衡，多台redis负载均衡。

	总之，负载均衡，就是通过相应的算法把要处理的业务分给某个服务去处理。要点就是一个入口，多个服务。

	nginx已经提供了负载均衡配置项，下面简单总结下

##### 2，实现

	在在 http 指令下配置 upstream

	语法：
		upstream name { ... } 
		默认值: — 
		上下文: http

	语法: 
		server address [parameters]; 
		默认值: — 
		上下文: upstream

			parameters详解：
				weight=num        配置权重
				max_fails=number  定Nginx与服务器通信的尝试失败的次数，默认为1
				fail_timeout=time 统计失败尝试次数的时间段,结合max_fails使用，默认10s	
				backup 			  标记为备用服务器，只有其他服务器出故障，使用此服务器
				down 			  标记服务器永久不可用

	反向代理：
		proxy_pass url/upstreamName;
		上下文：location

		例如：
		server{
			location / {
				proxy_pass http://loadbalanceTest;
			}
		}

		例如：
			http{
				#配置负载均衡服务 weight为权重，不加权重每个服务的权重默认为1
				#8.8.8.x:9001是http服务
				upstream loadbalanceTest {    
					server  8.8.8.3:9001 weight=5;    
					server  8.8.8.4:9001;    
				}
				
				server{
					#反向代理
					location / {
						#代理到loadbalanceTest配置中
						proxy_pass http://loadbalanceTest;
					}
				}
			}



#####3，nginx负载均衡机制

1，轮询

	默认轮询方式，当接收到请求后，轮流分给内部服务器

	此种负载均衡算法适合服务器组内部的服务器都具有相同的配置并且平均服务请求 相对均衡的情况


2，加权轮询

	需要配置weight参数，然后按照权重轮询

	此种负载均衡算法适合给不同性能的服务配置，性能高的服务器可相应权重高一些

3，IP Hash

	需要在 upstream 当中配置 ip_hash  

	这种方式通过生成请求源IP的哈希值，并通过这个哈希值来找到正确的真实服务器，不需要考虑session共享

4，最少连接数 

	需要在 upstream 当中配置 least_conn 实现最少连接数
	
	不同请求的处理时间肯定不同，如果A服务器有较多连接，而B服务器没有连接的话，新进来的请求并不是按照轮
	询分配，而是A达到最大连接数的时候将请求分给B。


##### 4,失败重试

	根据上文提到的max_fails=number和fail_timeout=time配合，可以进行失败重试。
	假如：max_fails=2,fail_timeout=60 表示失败2次之后，60s内不再重试，标记它为不可用服务器.
	过了60s再进行重试。

	失败重试详情配置：
		proxy_next_upstream 

		语法: proxy_next_upstream type1|type2……；
			#type:
				error 				建立连接，发送请求，接受请求出现错误则重试
				timeout 			超时则重试
				invalid_header 		header非法则重试
				http_500			返回对应的状态码则重试
			    http_502
				http_503 
				http_504 
				http_404 
				 off ...; 			停止发送请求

		默认值: proxy_next_upstream error timeout; //默认出错或者超时则重试
		上下文: http, server, location


		重试其他相关配置：

			proxy_next_upstream_tries  number
				#设置重试次数，默认0表示不限制，注意此重试次数指的是所有请求次数
				（包括第一次和之后的重试次数之和）。
			proxy_next_upstream_timeout time
				# 设置重试最大超时时间，默认0表示不限制。即在 proxy_next_upstream_timeout 时间内允许 proxy_next_upstream_tries 次重试。如果超过了其中一个设置，则 Nginx 也会结束重试并返回客户 端响应（可能是错误码）			
			proxy_send_timeout         发送给代理的超时时间
		    proxy_read_timeout         和代理服务器连接成功,后端服务器响应超时时间
		    proxy_connect_timeout      nginx连接后端服务器超时时间