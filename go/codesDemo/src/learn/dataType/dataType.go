package dataType

import (
	"fmt"
)


func init(){
	fmt.Println("Success")
}


func init(){
	fmt.Println("This is init")
}


func TestDataType (){
	fmt.Println("dataType")
}

func DataTypeDemo(){
	var str = "C语言中文网\nGo语言教程"
	fmt.Println(str[3])
}

func btoi(b bool) int {
	if b {
		return 1
	}
	return 0
}


