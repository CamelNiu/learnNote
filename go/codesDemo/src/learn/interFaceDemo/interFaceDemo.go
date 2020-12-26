package interFaceDemo

//go语言接口demo，学习
import (
	"fmt"
)

func TestITFCDemo(){
	//fmt.Println("itfc");
	//f := new(file)
	//fmt.Println(f)
	//
	//var writer DataWriter
	//
	//writer = f
	//
	//writer.WriteData("data")
	cainiao()
}

//1，go语言利用接口实现很多面向对象特性
//2，隐式实现


//接口类型，对其他类型的抽象和概括。
//接口是双方约定的一种合作协议。抽象格式
//每个接口类型，由多个方法组成
type Writer interface {
	Write(p []byte) (n int,err error)
}

type Stringer interface {
	String() string
}

type DataWriter interface {
	WriteData(data interface{}) error
}

type file struct {

}

func (d *file) WriteData(data interface{}) error {
	fmt.Println("WriteData:",data)
	return nil
}

//go语言提供的接口，是个数据类型，此数据类型把具有共性的方法定义在一起。
//任何其他类型只要实现了这些方法，就是实现了这个接口
//type interfaceName interface {
//	method_name1 [return_type1]
//	method_name2 [return_type2]
//	...
//}
//
//type struct_name struct {
//
//}
//
//func (struct_name_variable struct_name) method_name1()[return type]{
//	/**/
//}
//
//func (struct_name_variable struct_name) method_name2()[return type]{
//	/**/
//}

type Phone interface {
	call() (err error)
}

type NokiaPhone struct {

}

func (NokiaPhonedemo NokiaPhone) call() (err error){
	fmt.Println("I am Nokia,call you")
	return nil
}

type Iphone struct {

}

func(IphoneDemo Iphone) call() (err error){
	fmt.Println("I am iphone,call you")
	return nil 
}

func cainiao(){
	var phone Phone

	phone = new(NokiaPhone)
	phone.call()


	phone = new(Iphone)
	phone.call()
}