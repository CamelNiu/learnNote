package container

import (
	"fmt"
)

func ActionMain()  {
	arr()
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
	fmt.Printf("%T",p)

}