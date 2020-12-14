package dataType

import (
	"fmt"
	"strconv"
)

//
//func init(){
//	fmt.Println("Success")
//}
//
//
//func init(){
//	fmt.Println("This is init")
//}
//

//func TestDataType (){
//	fmt.Println("dataType")
//}
//
//func DataTypeDemo(){
//	var str = "C语言中文网\nGo语言教程"
//	fmt.Println(str[3])
//}
//
//func btoi(b bool) int {
//	if b {
//		return 1
//	}
//	return 0
//}

func SwapType(){

	//num := 100
	//str := strconv.Itoa(num)
	//fmt.Printf("Type:%T value:%#v",str,str)
	//
	//str = "900"
	//num = strconv.Atoi(str)
	//fmt.Printf("Type:%T value:%#v",num,num)

	str1 := "110"
	str2 := "s100"
	num1,err := strconv.Atoi(str1)

	if err != nil {
		fmt.Printf("%v 转换失败",str1)
	}else{
		fmt.Printf("Type:%T,value %v\n",num1,num1)
	}


	num2,err := strconv.Atoi(str2)

	if err != nil {
		fmt.Printf("%v 转换失败",str2)
	}else{
		fmt.Printf("Type:%T,value %v\n",num2,num2)
	}




}
