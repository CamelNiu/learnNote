package pointer

import (
	"fmt"
	"flag"
)

func MainPointer(){
	//fmt.Println("main_pointer")
	//demo1()
	//demo2()
	//swap()
	demo4()
	demoNew()
}

func demo1(){
	//var val int
	//val = 10
	//ptr := &val
	//valPtr := *ptr
	//fmt.Println(ptr,valPtr)
	//
	//var testStr string
	//testStr = "huhuhu hahah ,niushaogang ,,gangge ,hhhnihaonihaonihaohao开心不开心"
	//ptrTestStr := &testStr
	//fmt.Println("%p",ptrTestStr)

	//var cat int = 1
	var str string = "banana"

	fmt.Printf("%p",&str)

}

func demo2(){
	var house string = "hahahahaha"
	var ptr *string
	ptr = &house
	intDemo := 568

	fmt.Printf("ptf type: %T\n",ptr)
	fmt.Printf("ptf type: %T\n",house)
	fmt.Printf("ptf type: %T\n",intDemo)
	fmt.Println(ptr)
	fmt.Println(*ptr)
	fmt.Printf("type %T",*ptr)
}

func demo3(){
	a,b := 8,9
	swap2(&a,&b)
	fmt.Println(a,b)

}

//func swap(a,b *int){
//	t := *a
//	*a = *b
//	*b = t
//}

func swap2(a,b *int){
	b,a = a,b
}


var mode = flag.String("mode","","process mode")

func demo4(){
	//解析命令行参数
	flag.Parse()
	//输出命令行参数
	fmt.Println(*mode)
}


func demoNew(){
	str := new(string)
	int := new(int)
	*str = "abc"
	*int = 123
	fmt.Println(*str)
	fmt.Println(*int)
}