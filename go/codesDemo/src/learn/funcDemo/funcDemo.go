package funcDemo

import "fmt"

func TestFuncDemo()  {
	in := Data{
		complax: []int{1,2,3},
		instance: InnerData{
			5,
		},
		ptr:&InnerData{1},
	}

	fmt.Printf("in value : %+v\n",in)
	fmt.Printf("in ptr:%p\n",&in)

	out := passByValue(in)

	fmt.Printf("out value : %+v\n",out)
	fmt.Printf("out ptr:%p\n",&out)

}

//批量定义常量
const (
	SecondsPerMinute = 60
	SecondsPerHour = SecondsPerMinute * 60
	SecondsPerDay = SecondsPerHour * 24
)

//===================1，写函数，定义返回值名称的返回值，return自动返回，按照顺序=======================
func resolveTime(seconds int) (day,hour,minute int)  {
	day = seconds / SecondsPerDay
	hour = seconds / SecondsPerHour
	minute = seconds / SecondsPerMinute
	return
}




//=================2，go语言传入参数和返回参数在调用过程中都是使用值传递，也就是复制。=======================
//=========但是指针，切片和map等等的引用型对象在参数重传递不会发生复制，而是复制指针，相当于做了一次引用==========

type Data struct {
	complax []int
	instance InnerData
	ptr *InnerData
}

type InnerData struct {
	a int
}

func passByValue(inFunc Data) Data {
	fmt.Printf("inFunc value:%+v\n",inFunc)
	fmt.Printf("inFunc ptr: %p\n",&inFunc)
	return inFunc
}