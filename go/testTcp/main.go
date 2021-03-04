package main

import (
	"fmt"
	"unsafe"
)

func main()  {
	a := []byte("牛少刚 牛少刚")

	fmt.Println(a)
	fmt.Println( unsafe.Sizeof(a) )
}
