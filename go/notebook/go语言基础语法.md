## go语言基础语法

#####go语言常量

1,定义常量

	const constName [type] = value
	
	const (
	
		constName1 [type] = value1
		constName2 [type] = value2
		constName3 [type] = value3

	)
	
2，iota

	type ABC int
	
	const(
		name1 ABC  = iota
		name2
		name3
		name4
		name5
		...
	)
	
3,无类型常量

	无类型的布尔型、无类型的整数、无类型的字符、无类型的浮点数、无类型的复数、无类型的字符串
	
	例如：
		math.pi
	
	通过延迟明确常量的具体类型，不仅可以提供更高的运算精度，而且可以直接用于更多的表达式而不需要显式的类型转换


#####go枚举类型

	go语言没有枚举类型，可以利用const+iota模拟枚举类型
	
	枚举类型赋值，
	枚举类型转换字符串(需要写枚举类型方法)

#####go语言关键字

1,关键字

	break		
	default  --
	func
	interface
	select --
	case 
	defer --
	go --
	map --
	struct
	chan --
	else
	goto --
	package 
	switch
	const
	fallthrough --
	if
	range --
	type --
	continue 
	for
	import
	return
	var

2，预定义标识符

	append
	bool
	byte --
	cap --
	close --
	complex --
	complex64 --
	complex128 --
	copy --
	false
	float32
	float64
	imag --
	int
	int8
	int16
	int32
	int64
	iota --
	len --
	make
	new
	nil
	panic --
	uint
	uint8
	uint16
	uint32
	uint64
	print
	println
	real --
	recover --
	string
	true
	uintptr 
	

#####类型转换(string/int)
import "strconv"


1,Itoa/Atoi

	1,ItoA 	int->string
	2,Atoi 	string->int
	
2,Parse(string->int)

	ParseBool() 
		"1,0,t,f,T,F,Ture,ture,False,flase,TRUE,FALSE"
	ParseFloat()
		指定 float32，float64
	ParseInt()
		"指定进制，指定输出结果必须无溢出类型"
		0，8，16，32，64
	ParseUint()
		同上，必须无符号
	注意：Parse 系列函数都有两个返回值，第一个返回值是转换后的值，第二个返回值为转化失败的错误信息。

3，Format(int->string)

	FormatBool()
	FormatInt()
		参数 i 必须是 int64 类型，参数 base 必须在 2 到 36 之间，返回结果中会使用小写字母“a”到“z”表示大于 10 的数字
	FormatUint()
		用法同上，参数 i 必须是无符号的 uint64 类型
	FormatFloat()
		
4，Append(int->string->slice)

	AppendBool()
	AppendFloat()
	AppendInt()
	AppendUint()
	
	注意：Append 系列函数和 Format 系列函数的使用方法类似，只不过是将转换后的结果追加到一个切片中