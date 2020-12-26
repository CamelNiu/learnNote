//go语言基础
package basic

import(
	"fmt"
	"strconv"
	"time"
	"math"
)


func DemoBasic()  {
	//stringToInt()
	//demoParse()
	//demoFormat()
	//demoAppend()
	demoConst()
	demoEnum()
}

/**
Itoa
Atoi
strconv
 */
func stringToInt()  {
	num := 100
	str := strconv.Itoa(num)
	fmt.Printf("type:%T value:%#v\n", str, str)
	str1 := "100"
	num1,_ := strconv.Atoi(str1)
	fmt.Printf("type:%T value:%#v\n",num1,num1)
	str2 := "a100"
	num2,err:= strconv.Atoi(str2)
	fmt.Println(err)
	fmt.Printf("Type:%T value:%#v\n",num2,num2)
}


func demoParse() {
	//ParseBool
	str := "abc"
	bool,err := strconv.ParseBool(str)

	if err != nil {
		fmt.Printf("str1:%v\n",err)
	}else{
		fmt.Println(bool)
	}

	//ParseInt()
	//数据，进制，0。8。16。64
	//Parse 系列函数都有两个返回值，第一个返回值是转换后的值，第二个返回值为转化失败的错误信息
	str1 := "-1108"
	num,err := strconv.ParseInt(str1,10,0)
	if err != nil {
		fmt.Println(err)
	} else {
		fmt.Println(num)
	}

	//ParseUint()
	str2 := "-11"
	num1, err1 := strconv.ParseUint(str2, 10, 0)
	if err != nil {
		fmt.Println(err1)
	} else {
		fmt.Println(num1)
	}

	//ParseFloat
	str3 := "3.141590653"
	num3,err3 := strconv.ParseFloat(str3,64)
	if err != nil {
		fmt.Println(err3)
	}else{
		fmt.Println(num3)
	}
}

func demoFormat() {
	//Format 系列函数实现了将给定类型数据格式化为字符串类型的功能
	num := true
	str := strconv.FormatBool(num)
	fmt.Printf("%T,%v\n",str,str)

	var num1 int64 = -100
	str1 := strconv.FormatInt(num1,10)
	fmt.Printf("%T,%v\n",str1,str1)

	var num2 uint64  = 85623
	str2 := strconv.FormatUint(num2,10)
	fmt.Println("%T,%v\n",str2,str2)

	var num3 float64 = 3.141592653
	str3 := strconv.FormatFloat(num3,'E',-1,64)
	fmt.Println("%T,%v\n",str3,str3)


}

/**
	Append 系列函数用于将指定类型转换成字符串后追加到一个切片中，其中包含 AppendBool()、AppendFloat()、AppendInt()、AppendUint()。
 */
func demoAppend()  {
	b10 := []byte("int (base10):")
	fmt.Println(b10)
	b10 = strconv.AppendInt(b10,-42,10)
	fmt.Println(b10)

	b16 := []byte("int (base 16):")
	fmt.Println(b16)
	b16 = strconv.AppendInt(b16,-42,16)
	fmt.Println(b16)
}

/**
常量是在编译时被创建,
只能是布尔型、数字型（整数型、浮点型和复数）和字符串型,也就是能被编译器求值的常量表达式
所有常量的运算都可以在编译期完成，这样不仅可以减少运行时的工作，也方便其他代码的编译优化
常量间的所有算术运算、逻辑运算和比较运算的结果也是常量，对常量的类型转换操作或以下函数调用都是返回常量结果
因为它们的值是在编译期就确定的，因此常量可以是构成类型的一部分
 */
func demoConst(){
	//const name [type] = value
	const pi = 3.141526
	const b = "this is const"
	fmt.Println(b)
	fmt.Println(pi)
	//常量的值必须是能够在编译时就能够确定的，可以在其赋值表达式中涉及计算过程，但是所有用于计算的值必须在编译期间就能获得
	const c float64 = 3/2
	fmt.Println(c)
	fmt.Printf("%T,%v",c,c)

	const noDelay time.Duration = 0
	const timeout = 5*time.Minute

	fmt.Println(noDelay)
	fmt.Println(timeout)


	//iota常量生成器初始化常量，生成一组以相似规则初始化的常量

	type Weekday int

	const (
		Sunday Weekday = iota
		Monday
		Tuesday
		Wednesday
		Thursday
		Friday
		Saturday
	)

	fmt.Println(Wednesday)

	var x float32 = math.Pi
	var y float64 = math.Pi
	var z complex128 = math.Pi
	fmt.Println(x)
	fmt.Println(y)
	fmt.Println(z)

	//无类型常量
	//这里有六种未明确类型的常量类型，分别是无类型的布尔型、无类型的整数、无类型的字符、无类型的浮点数、无类型的复数、无类型的字符串，延迟明确类型，提高运算精度

	const Pi64 float64 = math.Pi

	fmt.Println(Pi64)

	var w float32 = float32( Pi64 )

	fmt.Println(w)

	var v  complex128 = complex128(Pi64)
	fmt.Println(v)


}

/**
go语言没有枚举类型，可以使用const和iota来模拟枚举类型
 */

type ChipType int

const (
	None ChipType = iota
	CPU
	GPU
)

func (c ChipType) String() string {
	switch c {
	case None:
		return "None"
	case CPU :
		return "CPU"
	case GPU :
		return "GPU"
	}
	return "N/A"
}

func demoEnum () {

	type Weapon int

	const (
		Arrow Weapon = iota
		Shuriken
		SniperRifle
		Rifle
		Blower
	)

	fmt.Println(Arrow, Shuriken, SniperRifle, Rifle, Blower)

	var a Weapon = Blower
	fmt.Println(a)


	const (
		FlagNone = 1 << iota
		FlagRed
		FlagGreen
		FlagBlue
	)
	fmt.Println( FlagRed, FlagGreen, FlagBlue)
	fmt.Printf("%d %d %d\n", FlagRed, FlagGreen, FlagBlue)
	fmt.Printf("%b %b %b\n", FlagRed, FlagGreen, FlagBlue)



	fmt.Printf("%T\n",CPU)

	res := CPU.String()
	fmt.Printf("%T\n",res)

	fmt.Printf("%s %d", CPU, CPU)

}

