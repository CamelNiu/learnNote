package calc

import (
	"fmt"
	"reflect"
)

//func testDemo() {
//	fmt.Println("testDemo")
//}

var opers map[string]interface{}

func init() {
	opers = make(map[string]interface{},0)
	opers["+"] = NewAdd
	opers["-"] = NewSub
	opers["*"] = NewMul
	opers["/"] = NewDiv
}

func OperationFactory(num1,num2 int,flag string)  {
	oper := opers[flag]
	valueOper := reflect.ValueOf(oper)
	fmt.Println("reflect.ValueOf(oper)", valueOper)
	fmt.Printf("type:%T \n", valueOper)

	args := []reflect.Value{
		reflect.ValueOf(num1),
		reflect.ValueOf(num2),
	}

	arrValueOper := valueOper.Call(args)[0]

	fmt.Println("valueOper.Call", arrValueOper)
	// reflect.Value => 解析为原来的对象 OperationInterface
	fmt.Printf("type:%T \n", arrValueOper)

	operationin := arrValueOper.Interface().(OperationInterface)
	fmt.Printf("retopertionin-type:%T \n", operationin)
	result := operationin.Exe()
	fmt.Println(result)

}