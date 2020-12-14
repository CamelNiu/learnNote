package test

import (
	"fmt"
)

func TestMain(){
	fmt.Println("tertMain")
}

func Add(a int,b int) int {
	return a+b
}

func Mul(a int,b int) int {
	return a*b
}