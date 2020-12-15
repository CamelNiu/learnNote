package container

import (
	"fmt"
)

func ActionMain()  {
	//arr()
	//mutiArr()
	//sliceDemo()
	operateSlice()
}

func arr(){
	//数组，固定长度，特定元素，元素数量零个或者多个组成
	//var arrName [elementNum]Type
	//Type为数组本身时，可以实现多维数组
	//下标访问数组，len()返回数组长度

	var a [3]int
	fmt.Println(a[0])
	fmt.Println(a[len(a)-1])

	for i,v := range a {
		fmt.Printf("%d %d\n",i,v)
	}

	for _,v := range a {
		fmt.Printf("%d\n",v)
	}

	for k,_ := range a {
		fmt.Printf("%d\n",k)
	}
	//数组未初始化，会默认当前类型零值
	//数组初始化
	var q [3]int = [3]int{1,2,3}
	var r [3]int = [3]int{1,2}

	fmt.Println(q[2])
	fmt.Println(r[2])

	//...表示数组的长度是根据初始化值的时候元素个数来计算

	p := [...]int{3,4,5,6,7,8}
	fmt.Printf("%T\n",p)

	//大小
	// [3]int{1,2,3}
	//q = [4]int{1,2,3,4}
	
	x := [2]int{1,2}
	y := [...]int{1,2}
	z := [2]int{1,3}
	fmt.Println(x == y,x==z,y==z)

	var arrTeam [3]string

	arrTeam = [3]string{"hammer","soldier","mum"}

	for k,v := range arrTeam {
		fmt.Println(k,v)
	}

}


func mutiArr(){
	//多维数组，场景为具有父子关系或者坐标系相关数据
	//var arrName [size][size]...[size] array_type
	//了解其本质，二维数组也是由众多一维数组构成的
	var arr1 [2][2]int
	arr1 = [2][2]int{{1,2},{3,4}}

	arr1[0][0] = 8

	fmt.Println(arr1[0][0])

}

func sliceDemo(){
	//go语言切片，对数组的一个连续片段的引用，引用类型。内部包含地址，大小和容量，切片一般用于快速地操作一块数据集合
	//切片默认指向一段连续内存区域，可以是数组，也可以是切片本身。
	//slice [start:end]

	//var a = [3]int{1,2,3}
	//fmt.Println(a,a[1:2])

	var highRiseBuilding [30] int
	for i:=0;i<30;i++{
		highRiseBuilding[i] = i+1
	}
	//fmt.Println(highRiseBuilding)
	//fmt.Println(highRiseBuilding[10:15])
	//fmt.Println(highRiseBuilding[10:])
	//fmt.Println(highRiseBuilding[:5])
	//
	//a := []int{1,2,3}
	//fmt.Println(a[:])
	//fmt.Println(a[0:0])
	//
	//var strList []string
	//var numList []int
	//var numListEmpty = []int{}
	//fmt.Println(strList,numList,numListEmpty)
	//fmt.Println(len(strList),len(numList),len(numListEmpty))
	//
	//fmt.Println(strList == nil)
	//fmt.Println(numList == nil)
	//fmt.Println(numListEmpty == nil)//因为numListEmpty已经被分配了内存，但是没有元素，和nil比较是false

	//make([]Type,size,cap)

	//a := make([]int,2)
	//b := make([]int,2,10)
	//fmt.Println(a,b)
	//
	//fmt.Println(len(a),len(b))

	//使用 make() 函数生成的切片一定发生了内存分配操作，但给定开始与结束位置（包括切片复位）的切片只是将新的切片结构指向已经分配好的内存区域，设定开始与结束位置，不会发生内存分配操作。

	var a = [3] int{1,2,3}
	b := a[1:2]

	fmt.Printf("%T",b)

}

func operateSlice(){

}