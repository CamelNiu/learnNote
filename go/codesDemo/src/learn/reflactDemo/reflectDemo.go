package reflactDemo

import (
	"fmt"
	"reflect"
)

type Enum int

const (
	Zero Enum = 0
)

func TestReflactDemo () {
	//var a int
	//typeOfA := reflect.TypeOf(a)
	//fmt.Println(typeOfA.Name(),typeOfA.Kind())
	//
	//var b = "abcdefg"
	//typeOfB := reflect.TypeOf(b)
	//fmt.Println(typeOfB.Name(),typeOfB.Kind())

	//type cat struct {
	//
	//}
	//
	//typeOfCat := reflect.TypeOf(cat{})
	//
	//fmt.Println(typeOfCat.Name(),typeOfCat.Kind())
	//
	//typeOfZero := reflect.TypeOf(Zero)
	//
	//fmt.Println(typeOfZero.Name(),typeOfZero.Kind())

	//type cat struct {
	//
	//}
	//ins := &cat{}
	//
	//typeOfCat := reflect.TypeOf(ins)
	//fmt.Println(typeOfCat.Name(), typeOfCat.Kind())
	//typeOfCat = typeOfCat.Elem()
	//fmt.Printf("element name: '%v', element kind: '%v'\n", typeOfCat.Name(), typeOfCat.Kind())

	//type cat struct {
	//	Name string
	//	Type int `json:"type" id:"100"`
	//}
	//
	//ins := cat{Name:"mini",Type: 1}
	//
	//typeOfCat := reflect.TypeOf(ins)
	//
	//for i:=0;i<typeOfCat.NumField();i++ {
	//	fieldType := typeOfCat.Field(i)
	//	fmt.Printf("name: %v  tag: '%v'\n", fieldType.Name, fieldType.Tag)
	//}
	//
	//if catType,ok := typeOfCat.FieldByName("Type");ok{
	//	fmt.Println(catType.Tag.Get("json"),catType.Tag.Get("id"))
	//}

	type cat struct {
		Name string
		Type int `json:"type" id:"100"`
	}

	typeOfCat := reflect.TypeOf(cat{})

	if catType,ok := typeOfCat.FieldByName("Type");ok {
		fmt.Println(catType.Tag.Get("id"))
	}




}


