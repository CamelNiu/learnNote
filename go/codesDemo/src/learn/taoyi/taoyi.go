package taoyi

import (
	"fmt"
)

func Taoyi(){
	//fmt.Println("Taoyi")
	//y := calc(3,6)
	//fmt.Println(y)
	var a int
	void()
	fmt.Println(a,dummy(0))
}

func calc(a,b int) int {
	var c int
	c = a * b

	var x int
	x = c * 10

	return x
}

func dummy(b int) int {
	var c int
	c = b
	return c
}

func void(){

}

