package reflactDemo

import (
	"fmt"
	"reflect"
)

func learnReflect()  {

	//type stu struct {
	//	name string
	//	age int
	//	sex string
	//}
	//
	//i := stu{
	//	name:"NiuShaoGang",
	//	age:18,
	//	sex:"male",
	//}

	i := "10"

	ref(i)

}


func ref(i interface{}){
	rt := reflect.TypeOf(i)
	rv := reflect.ValueOf(i)
	//fmt.Println(rt)
	//fmt.Println(rv)
	//fmt.Println(rt.NumField())
	//for i := 0;i < rv.NumField(); i++{
	//	//fmt.Println(rv.Field(i))
	//}
	//rvi := rv.Interface()
	//fmt.Println(rvi)
	//
	//rtv := rt.Name()
	//fmt.Println(rtv)
	fmt.Println(rt)
	fmt.Println(rv)

	// fmt.Printf("type rtv: %s\n", rtv)
	// // reflect.TypeOf(i) ==>> reflect.ValueOf(i) ==>> Interface()
	// fmt.Printf("type rvi: %T\n", rvi)
}