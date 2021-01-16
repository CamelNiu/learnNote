package structDemo

import "fmt"

/**
结构体，是一种自定义类型。
结构体定义只是一种对内存布局的描述
结构体实例化之后，才会真正的分配内存
结构体实例化之后，结构体实例和实例之间的内存是完全独立的
 */

/**
结构体实例化：
1，非指针类型的结构体
var ins T
2,指针类型的结构体
ins := new(T)
3,结构体取地址实例化
ins := &T{}
取地址实例化是最广泛的一种结构体实例化方式，可以使用函数封装上面的初始化过程
 */

func DemoMain()  {
	type Point struct {
		X int
		Y int
	}

	var p Point
	p.X = 10
	p.Y = 20
	fmt.Println(p)

	fmt.Printf("%T \n",p)


	q := new(Point)
	q.X = 30
	q.Y = 40

	fmt.Println(q)

	fmt.Printf("%T\n",q)

}

