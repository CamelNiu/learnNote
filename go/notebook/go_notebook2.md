### go语言学习笔记

 1，项目目录
 
 	理解：gopath,goroot
 
 	go install
 	
 	bin
 	src
 	pkg
 	
 	
 
 
 2，语言特点
 
 	简单语法定义
 	1，变量定义，全局，局部
 	2，常量定义
 		全局赋值，var()
	 	，const(
	 	
	 	)
	3,结构体
		func
		interface
		struct
		
		type abc func() 定义方法类型
		type def interface{}
		type ghi struct{
			name string
			age int
		}
		
		
		
		struct := structDemo{
			name:'',
			age:9,		
		}
 
 		结构体，结构体属性赋值
 		
 		structDemo.name
 		sttuctDemo.age
 		
 		
 		定义方法，函数
 		
 		func fun(){}
 		
 		func（u user） tostrint(){
 		
 		}
 		
 		结构体方法理解
 		
 		函数，方法
 		方法是根据结构体定义的，调用方法，一定要创建结构体才可以调用，实例化
 
 		u，当前结构体的实例化
 
 
 		作用域：
 		
 		main，项目里其他地方 
 		main只有一个
 
 		引用，统计目录全局可见
 		
 		包名.
 		
 		
 	声明函数外，且首字母大写，整个程序包都可见作用域，结构体里的方法
 		
 		运算符 
 		
 
 3，包概念
 
 		官方包，标准库
 		第三方包
 		
 			go get 包 引入包
 			import （
 				sms "abc/def/ddd/ddd/sms"
 			
 			）
 			
 			alias别名
 			
 		
 		自己写的包
 		
 		
 		func init(){
 		
 		}
 		main方法之前执行，go的构造函数，引入包的顺序进行，go的包实现的执行顺序，可以定义多个，场景就是初始化项目
 		
 
 关键字，go的返回值，作用域声明，
  
 
 计算器结构体，简单版本，结合结构体Scan，
 
 4，变量常量数据类型
 
 
 